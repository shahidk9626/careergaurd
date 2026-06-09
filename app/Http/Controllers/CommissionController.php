<?php

namespace App\Http\Controllers;

use App\Models\StaffDetail;
use App\Models\PurchasedPlan;
use App\Models\User;
use App\Models\StaffCommissionPayment;
use App\Models\StaffCommissionPaymentDetail;
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
            $statusFilter = $request->input('status');
            $batchRefFilter = $request->input('batch_reference');

            $data = $staffDetails->map(function ($detail) use ($period, $startDate, $endDate, $statusFilter, $batchRefFilter) {
                $staffUserId = $detail->user_id;
                
                // Fetch stats based on period
                $stats = $this->getCommissionData($staffUserId, $period, $startDate, $endDate, $statusFilter, $batchRefFilter);

                return [
                    'staff_code' => $detail->emp_code,
                    'staff_name' => $detail->user->name ?? $detail->full_name,
                    'role' => $detail->user->role->name ?? 'Staff',
                    'active_policies' => $stats['total_policies'],
                    'premium_generated' => $stats['total_premium'],
                    'commission_earned' => $stats['total_commission'],
                    'commission_due' => $stats['total_due'],
                    'commission_paid' => $stats['total_paid'],
                    'commission_rejected' => $stats['total_rejected'],
                ];
            });

            // Filter out staff members with no active policies matching the criteria
            if ($statusFilter || $batchRefFilter) {
                $data = $data->filter(fn($x) => $x['active_policies'] > 0)->values();
            }

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
            'status' => 'nullable|string|in:Pending,Paid,Hold,Rejected',
            'batch_reference' => 'nullable|string',
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
        $statusFilter = $request->input('status');
        $batchRefFilter = $request->input('batch_reference');

        // Calculate Stats
        $overallStats = $this->getCommissionData($staffUser->id, 'overall');
        $currentMonthStats = $this->getCommissionData($staffUser->id, 'current_month');
        $periodStats = $this->getCommissionData($staffUser->id, $period, $startDate, $endDate, $statusFilter, $batchRefFilter);

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
     * Manage individual policy commission status
     */
    public function manageCommission(Request $request)
    {
        $request->validate([
            'purchased_plan_id' => 'required|exists:purchased_plans,id',
            'status' => 'required|in:Pending,Paid,Hold,Rejected',
            'description' => 'required_if:status,Hold,Rejected|nullable|string',
            'screenshot' => 'required_if:status,Paid|nullable|file|mimes:jpeg,png,jpg,pdf|max:4096',
        ]);

        $plan = PurchasedPlan::with('plan')->findOrFail($request->purchased_plan_id);
        $commissionAmount = (float)($plan->plan->commission_amount ?? 0);

        // Find or create detail record
        $detail = StaffCommissionPaymentDetail::firstOrNew([
            'purchased_plan_id' => $plan->id,
        ]);

        if ($detail->status === 'Paid') {
            return response()->json(['error' => 'This commission has already been paid and settled.'], 400);
        }

        $paymentId = null;
        if ($request->status === 'Paid') {
            if (!$request->hasFile('screenshot')) {
                return response()->json(['error' => 'A payment proof screenshot is required to mark as Paid.'], 400);
            }

            // Create a payout batch for this single policy payment
            $batchRef = 'COM-' . date('Ymd') . '-' . strtoupper(uniqid());
            $proofPath = $request->file('screenshot')->store('payment_proofs', 'public');

            $payment = StaffCommissionPayment::create([
                'staff_id' => $plan->referred_by,
                'batch_reference' => $batchRef,
                'total_policies' => 1,
                'total_commission_amount' => $commissionAmount,
                'payment_proof' => $proofPath,
                'description' => $request->description,
                'payment_date' => Carbon::now()->toDateString(),
                'created_by' => auth()->id(),
            ]);

            $paymentId = $payment->id;
        }

        $detail->fill([
            'payment_id' => $paymentId,
            'customer_id' => $plan->user_id,
            'plan_id' => $plan->plan_id,
            'commission_amount' => $commissionAmount,
            'status' => $request->status,
            'description' => in_array($request->status, ['Hold', 'Rejected']) ? $request->description : null,
        ])->save();

        return response()->json(['success' => 'Commission status updated successfully.']);
    }

    /**
     * Settle bulk policy commissions
     */
    public function bulkSettle(Request $request)
    {
        $request->validate([
            'staff_code' => 'required|string',
            'policy_ids' => 'required|array',
            'policy_ids.*' => 'exists:purchased_plans,id',
            'payment_date' => 'required|date',
            'description' => 'nullable|string',
            'screenshot' => 'required|file|mimes:jpeg,png,jpg,pdf|max:4096',
        ]);

        $staffDetail = StaffDetail::where('emp_code', $request->staff_code)->first();
        if (!$staffDetail) {
            return response()->json(['error' => 'Staff member not found.'], 404);
        }

        $plans = PurchasedPlan::with('plan')
            ->whereIn('id', $request->policy_ids)
            ->where('referred_by', $staffDetail->user_id)
            ->get();

        if ($plans->isEmpty()) {
            return response()->json(['error' => 'No matching policies found to settle.'], 400);
        }

        // Check already paid
        $alreadyPaid = StaffCommissionPaymentDetail::whereIn('purchased_plan_id', $request->policy_ids)
            ->where('status', 'Paid')
            ->exists();

        if ($alreadyPaid) {
            return response()->json(['error' => 'One or more selected policies are already Paid.'], 400);
        }

        $proofPath = $request->file('screenshot')->store('payment_proofs', 'public');

        $totalAmount = 0;
        foreach ($plans as $plan) {
            $totalAmount += (float)($plan->plan->commission_amount ?? 0);
        }

        $batchRef = 'COM-' . date('Ymd') . '-' . strtoupper(uniqid());

        $payment = StaffCommissionPayment::create([
            'staff_id' => $staffDetail->user_id,
            'batch_reference' => $batchRef,
            'total_policies' => $plans->count(),
            'total_commission_amount' => $totalAmount,
            'payment_proof' => $proofPath,
            'description' => $request->description,
            'payment_date' => $request->payment_date,
            'created_by' => auth()->id(),
        ]);

        foreach ($plans as $plan) {
            $detail = StaffCommissionPaymentDetail::firstOrNew([
                'purchased_plan_id' => $plan->id,
            ]);

            $detail->fill([
                'payment_id' => $payment->id,
                'customer_id' => $plan->user_id,
                'plan_id' => $plan->plan_id,
                'commission_amount' => (float)($plan->plan->commission_amount ?? 0),
                'status' => 'Paid',
                'description' => null,
            ])->save();
        }

        return response()->json(['success' => 'Bulk commission settlement successful! Batch reference: ' . $batchRef]);
    }

    /**
     * Get commission payment history logs for a staff member
     */
    public function paymentHistory(Request $request)
    {
        $request->validate([
            'staff_code' => 'required|string',
        ]);

        $staffDetail = StaffDetail::where('emp_code', $request->staff_code)->first();
        if (!$staffDetail) {
            return response()->json(['error' => 'Staff member not found.'], 404);
        }

        $payments = StaffCommissionPayment::with('creator')
            ->where('staff_id', $staffDetail->user_id)
            ->latest()
            ->get();

        $data = $payments->map(function ($payment) {
            $details = StaffCommissionPaymentDetail::with(['purchasedPlan', 'customer'])
                ->where('payment_id', $payment->id)
                ->get()
                ->map(fn($d) => [
                    'policy_number' => $d->purchasedPlan->plan_unique_id ?? 'N/A',
                    'customer_name' => $d->customer->name ?? 'N/A',
                    'amount' => $d->commission_amount,
                ]);

            return [
                'id' => $payment->id,
                'batch_reference' => $payment->batch_reference,
                'payment_date' => $payment->payment_date ? $payment->payment_date->format('Y-m-d') : 'N/A',
                'total_policies' => $payment->total_policies,
                'amount' => $payment->total_commission_amount,
                'description' => $payment->description ?? 'N/A',
                'proof' => $payment->payment_proof ? asset('storage/' . $payment->payment_proof) : '',
                'created_by' => $payment->creator->name ?? 'Admin',
                'policies' => $details,
            ];
        });

        return response()->json(['success' => true, 'payments' => $data]);
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
            'status' => 'nullable|string|in:Pending,Paid,Hold,Rejected',
            'batch_reference' => 'nullable|string',
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
        $statusFilter = $request->input('status');
        $batchRefFilter = $request->input('batch_reference');

        // Retrieve statistics
        $overallStats = $this->getCommissionData($staffUser->id, 'overall');
        $currentMonthStats = $this->getCommissionData($staffUser->id, 'current_month');
        $periodStats = $this->getCommissionData($staffUser->id, $period, $startDate, $endDate, $statusFilter, $batchRefFilter);

        $dateRangeLabel = $periodStats['label'];
        $referrals = $periodStats['referrals'];

        // Get payment history batches
        $payments = StaffCommissionPayment::with('creator')
            ->where('staff_id', $staffUser->id)
            ->latest()
            ->get();

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
            'payments' => $payments,
            'generated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'generated_by' => $user->name,
        ]);

        $filename = 'Commission_Invoice_' . $staffDetail->emp_code . '_' . Carbon::now()->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Compute statistics and referred policies list using plan-wise commission values
     */
    private function getCommissionData($staffUserId, $period, $startDate = null, $endDate = null, $statusFilter = null, $batchRefFilter = null)
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

        // Apply filters if set
        if ($statusFilter) {
            $query->where(function($q) use ($statusFilter) {
                if ($statusFilter === 'Pending') {
                    $q->whereNotExists(function($sub) {
                        $sub->select(DB::raw(1))
                            ->from('staff_commission_payment_details')
                            ->whereColumn('staff_commission_payment_details.purchased_plan_id', 'purchased_plans.id');
                    })->orWhereExists(function($sub) {
                        $sub->select(DB::raw(1))
                            ->from('staff_commission_payment_details')
                            ->whereColumn('staff_commission_payment_details.purchased_plan_id', 'purchased_plans.id')
                            ->where('status', 'Pending');
                    });
                } else {
                    $q->whereExists(function($sub) use ($statusFilter) {
                        $sub->select(DB::raw(1))
                            ->from('staff_commission_payment_details')
                            ->whereColumn('staff_commission_payment_details.purchased_plan_id', 'purchased_plans.id')
                            ->where('status', $statusFilter);
                    });
                }
            });
        }

        if ($batchRefFilter) {
            $query->whereExists(function($sub) use ($batchRefFilter) {
                $sub->select(DB::raw(1))
                    ->from('staff_commission_payment_details')
                    ->join('staff_commission_payments', 'staff_commission_payments.id', '=', 'staff_commission_payment_details.payment_id')
                    ->whereColumn('staff_commission_payment_details.purchased_plan_id', 'purchased_plans.id')
                    ->where('staff_commission_payments.batch_reference', 'like', '%' . $batchRefFilter . '%');
            });
        }

        $referrals = $query->latest()->get();

        $paymentDetails = DB::table('staff_commission_payment_details')
            ->whereIn('purchased_plan_id', $referrals->pluck('id'))
            ->get()
            ->keyBy('purchased_plan_id');

        $mapped = $referrals->map(function ($plan) use ($paymentDetails) {
            $premium = (float)$plan->amount;
            $commAmount = (float)($plan->plan->commission_amount ?? 0);
            
            $detail = $paymentDetails->get($plan->id);
            $commissionStatus = $detail ? $detail->status : 'Pending';
            $reason = $detail ? $detail->description : '';
            
            $paymentProof = '';
            $batchRef = '';
            $paymentDate = '';
            if ($detail && $detail->payment_id) {
                $payment = DB::table('staff_commission_payments')->where('id', $detail->payment_id)->first();
                if ($payment) {
                    $paymentProof = $payment->payment_proof ? asset('storage/' . $payment->payment_proof) : '';
                    $batchRef = $payment->batch_reference;
                    $paymentDate = $payment->payment_date;
                }
            }

            return [
                'id' => $plan->id,
                'customer_id' => $plan->user_id,
                'plan_id' => $plan->plan_id,
                'policy_number' => $plan->plan_unique_id,
                'customer_name' => $plan->user->name ?? 'N/A',
                'membership_name' => $plan->plan_name,
                'purchase_date' => $plan->start_date ? $plan->start_date->format('Y-m-d') : 'N/A',
                'premium_amount' => $premium,
                'commission_amount' => $commAmount,
                'status' => $plan->status,
                'commission_status' => $commissionStatus,
                'reason' => $reason,
                'payment_proof' => $paymentProof,
                'batch_reference' => $batchRef,
                'payment_date' => $paymentDate,
            ];
        });

        $totalPremium = $mapped->sum('premium_amount');
        $totalCommission = $mapped->sum('commission_amount'); // Earned

        $totalPaid = $mapped->filter(fn($x) => $x['commission_status'] === 'Paid')->sum('commission_amount');
        $totalDue = $mapped->filter(fn($x) => in_array($x['commission_status'], ['Pending', 'Hold']))->sum('commission_amount');
        $totalRejected = $mapped->filter(fn($x) => $x['commission_status'] === 'Rejected')->sum('commission_amount');

        $totalPolicies = $mapped->count();

        return [
            'referrals' => $mapped,
            'total_policies' => $totalPolicies,
            'total_premium' => $totalPremium,
            'total_commission' => $totalCommission,
            'total_paid' => $totalPaid,
            'total_due' => $totalDue,
            'total_rejected' => $totalRejected,
            'label' => $label,
            'start_date' => $start ? $start->format('Y-m-d') : null,
            'end_date' => $end ? $end->format('Y-m-d') : null,
        ];
    }
}
