<?php

namespace App\Http\Controllers;

use App\Models\StaffDetail;
use App\Models\PurchasedPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class CommissionController extends Controller
{
    /**
     * Display listing of staff and their commission calculations
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $isAdmin = ($user->id === 1) || ($user->role && $user->role->slug === 'admin');

        if ($request->ajax()) {
            if (!$isAdmin) {
                $staffDetails = StaffDetail::with(['user.role'])->where('user_id', $user->id)->get();
            } else {
                $staffDetails = StaffDetail::with(['user.role'])->get();
            }

            $period = $request->input('period', 'overall');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $data = $staffDetails->map(function ($detail) use ($period, $startDate, $endDate) {
                $staffUserId = $detail->user_id;
                
                // Fetch stats based on period
                $stats = $this->getCommissionData($staffUserId, $period, $startDate, $endDate);

                return [
                    'staff_code' => $detail->emp_code,
                    'staff_name' => $detail->user->name ?? $detail->full_name,
                    'role' => $detail->user->role->name ?? 'Staff',
                    'active_policies' => $stats['total_policies'],
                    'premium_generated' => $stats['total_premium'],
                    'commission_earned' => $stats['total_commission'],
                    'commission_due' => $stats['total_commission'], // Due = Earned for now
                ];
            });

            return response()->json(['data' => $data]);
        }

        return view('admin.commission.index', compact('isAdmin'));
    }

    /**
     * View detailed commission summary for a staff member
     */
    public function summary(Request $request)
    {
        $request->validate([
            'staff_code' => 'required|string',
            'period' => 'nullable|string|in:current_month,last_month,current_year,overall,custom',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $user = auth()->user();
        $isAdmin = ($user->id === 1) || ($user->role && $user->role->slug === 'admin');

        $staffDetail = StaffDetail::where('emp_code', $request->staff_code)->first();

        if (!$staffDetail || !$staffDetail->user) {
            return response()->json(['error' => 'No staff found with the entered code.'], 404);
        }

        // Security check: standard staff can only view their own summary
        if (!$isAdmin && $staffDetail->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        $staffUser = $staffDetail->user;
        $period = $request->input('period', 'overall');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Calculate Stats
        $overallStats = $this->getCommissionData($staffUser->id, 'overall');
        $currentMonthStats = $this->getCommissionData($staffUser->id, 'current_month');
        $periodStats = $this->getCommissionData($staffUser->id, $period, $startDate, $endDate);

        $profileImage = $staffUser->profile_image ? asset('storage/' . $staffUser->profile_image) : null;

        return response()->json([
            'success' => true,
            'staff' => [
                'name' => $staffUser->name,
                'code' => $staffDetail->emp_code,
                'designation' => $staffDetail->designation ?? 'Representative',
                'department' => $staffDetail->department ?? 'Sales',
                'email' => $staffUser->email,
                'phone' => $staffUser->phone ?? $staffUser->whatsapp_number ?? 'N/A',
                'joining_date' => $staffDetail->joining_date ? Carbon::parse($staffDetail->joining_date)->format('d M, Y') : 'N/A',
                'status' => $staffUser->status === 'active' ? 'Active' : 'Inactive',
                'profile_image' => $profileImage,
                'role' => $staffUser->role->name ?? 'Staff',
            ],
            'overall' => $overallStats,
            'current_month' => $currentMonthStats,
            'period' => $periodStats,
        ]);
    }

    /**
     * Download PDF commission statement
     */
    public function downloadInvoice(Request $request)
    {
        $request->validate([
            'staff_code' => 'required|string',
            'period' => 'nullable|string|in:current_month,last_month,current_year,overall,custom',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $user = auth()->user();
        $isAdmin = ($user->id === 1) || ($user->role && $user->role->slug === 'admin');

        $staffDetail = StaffDetail::where('emp_code', $request->staff_code)->first();

        if (!$staffDetail || !$staffDetail->user) {
            abort(404, 'Staff member not found.');
        }

        // Security check: standard staff can only download their own invoice
        if (!$isAdmin && $staffDetail->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $staffUser = $staffDetail->user;
        $period = $request->input('period', 'overall');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Retrieve statistics
        $overallStats = $this->getCommissionData($staffUser->id, 'overall');
        $currentMonthStats = $this->getCommissionData($staffUser->id, 'current_month');
        $periodStats = $this->getCommissionData($staffUser->id, $period, $startDate, $endDate);

        $dateRangeLabel = $periodStats['label'];
        $referrals = $periodStats['referrals'];

        $pdf = Pdf::loadView('admin.commission.invoice-pdf', [
            'staff' => [
                'name' => $staffUser->name,
                'code' => $staffDetail->emp_code,
                'designation' => $staffDetail->designation ?? 'Representative',
                'department' => $staffDetail->department ?? 'Sales',
                'email' => $staffUser->email,
                'phone' => $staffUser->phone ?? $staffUser->whatsapp_number ?? 'N/A',
                'joining_date' => $staffDetail->joining_date ? Carbon::parse($staffDetail->joining_date)->format('d M, Y') : 'N/A',
                'status' => $staffUser->status === 'active' ? 'Active' : 'Inactive',
                'role' => $staffUser->role->name ?? 'Staff',
            ],
            'periodStats' => $periodStats,
            'overallStats' => $overallStats,
            'currentMonthStats' => $currentMonthStats,
            'dateRangeLabel' => $dateRangeLabel,
            'referrals' => $referrals,
            'generated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'generated_by' => $user->name,
        ]);

        $filename = 'Commission_Invoice_' . $staffDetail->emp_code . '_' . Carbon::now()->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Compute statistics and referred policies list using plan-wise commission values
     */
    private function getCommissionData($staffUserId, $period, $startDate = null, $endDate = null)
    {
        $query = PurchasedPlan::with(['user', 'plan'])
            ->where('referred_by', $staffUserId)
            ->whereHas('plan')
            ->whereExists(function($q) {
                $q->select(DB::raw(1))
                  ->from('transactions')
                  ->whereColumn('transactions.plan_unique_id', 'purchased_plans.plan_unique_id')
                  ->where('transactions.payment_status', 'success');
            });

        $now = Carbon::now();
        $start = null;
        $end = null;
        $label = 'Overall';

        switch ($period) {
            case 'current_month':
                $start = $now->copy()->startOfMonth();
                $end = $now->copy()->endOfMonth();
                $label = $now->format('F Y');
                break;
            case 'last_month':
                $start = $now->copy()->subMonth()->startOfMonth();
                $end = $now->copy()->subMonth()->endOfMonth();
                $label = $now->copy()->subMonth()->format('F Y');
                break;
            case 'current_year':
                $start = $now->copy()->startOfYear();
                $end = $now->copy()->endOfYear();
                $label = $now->format('Y');
                break;
            case 'custom':
                if ($startDate && $endDate) {
                    $start = Carbon::parse($startDate)->startOfDay();
                    $end = Carbon::parse($endDate)->endOfDay();
                    $label = Carbon::parse($startDate)->format('d M, Y') . ' - ' . Carbon::parse($endDate)->format('d M, Y');
                }
                break;
            default:
                $label = 'Overall';
                break;
        }

        if ($start && $end) {
            $query->whereBetween('start_date', [$start, $end]);
        }

        $referrals = $query->latest()->get();

        $mapped = $referrals->map(function ($plan) {
            $premium = (float)$plan->amount;
            $commAmount = (float)($plan->plan->commission_amount ?? 0);
            return [
                'policy_number' => $plan->plan_unique_id,
                'customer_name' => $plan->user->name ?? 'N/A',
                'membership_name' => $plan->plan_name,
                'purchase_date' => $plan->start_date ? $plan->start_date->format('Y-m-d') : 'N/A',
                'premium_amount' => $premium,
                'commission_amount' => $commAmount,
                'status' => $plan->status,
            ];
        });

        $totalPremium = $mapped->sum('premium_amount');
        $totalCommission = $mapped->sum('commission_amount');
        $totalPolicies = $mapped->count();

        return [
            'referrals' => $mapped,
            'total_policies' => $totalPolicies,
            'total_premium' => $totalPremium,
            'total_commission' => $totalCommission,
            'label' => $label,
            'start_date' => $start ? $start->format('Y-m-d') : null,
            'end_date' => $end ? $end->format('Y-m-d') : null,
        ];
    }
}
