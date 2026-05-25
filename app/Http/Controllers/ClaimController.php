<?php

namespace App\Http\Controllers;

use App\Models\PurchasedPlan;
use App\Models\Transaction;
use App\Models\Claim;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ClaimController extends Controller
{
    /**
     * Display a listing of purchased plans.
     */
    public function purchasedPlans(Request $request)
    {
        $user = auth()->user();
        $query = PurchasedPlan::with(['user', 'plan'])->latest();

        // Customer sees only their own plans
        if ($user->role_id === 0) {
            $query->where('user_id', $user->id);
        }

        $plans = $query->get();

        return view('customer.purchased-plans', compact('plans'));
    }

    /**
     * View specific purchased plan details with tabs.
     */
    public function viewPlan($plan_unique_id)
    {
        $user = auth()->user();
        $purchasedPlan = PurchasedPlan::with(['user', 'plan.planServices.category'])
            ->where('plan_unique_id', $plan_unique_id)
            ->firstOrFail();

        // Customer security check
        if ($user->role_id === 0 && $purchasedPlan->user_id !== $user->id) {
            abort(403, 'Unauthorized access to this membership.');
        }

        $transactions = Transaction::where('plan_unique_id', $plan_unique_id)->latest()->get();

        return view('customer.purchased-plan-view', compact('purchasedPlan', 'transactions'));
    }

    /**
     * Display matured plans for claim management.
     */
    public function claimManagement(Request $request)
    {
        $user = auth()->user();
        $query = PurchasedPlan::with(['user', 'plan', 'claim.claimedTransaction'])->latest();

        // Role-based filtering
        if ($user->role_id === 0) {
            $query->where('user_id', $user->id);
        }

        // Maturity Condition: current_date >= purchase_date + claim_duration
        // maturity_date = created_at + plan.claim_duration_days
        $plans = $query->get()->filter(function ($purchasedPlan) {

            if (!$purchasedPlan->plan) {
                return false;
            }

            $purchaseDate = Carbon::parse($purchasedPlan->start_date);
            $claimDuration = $purchasedPlan->plan->claim_duration_days;

            $maturityDate = $purchaseDate->copy()->addDays($claimDuration);

            return now()->greaterThanOrEqualTo($maturityDate);
        });

        return view('customer.claim-management', compact('plans'));
    }

    /**
     * Show claim application form.
     */
    public function showClaimForm($plan_unique_id)
    {
        $user = auth()->user();
        $purchasedPlan = PurchasedPlan::with('plan')
            ->where('plan_unique_id', $plan_unique_id)
            ->firstOrFail();

        // Security check
        if ($purchasedPlan->user_id !== $user->id) {
            abort(403);
        }

        // Maturity check
        $purchaseDate = Carbon::parse($purchasedPlan->start_date);
        $claimDuration = $purchasedPlan->plan->claim_duration_days ?? 0;
        $maturityDate = $purchaseDate->copy()->addDays($claimDuration);

        if (now()->lessThan($maturityDate)) {
            return redirect()->back()->with('error', 'This membership has not matured yet.');
        }

        if ($purchasedPlan->status === 'claimed') {
            return redirect()->back()->with('error', 'This membership has already been supported.');
        }

        return view('customer.claim-form', compact('purchasedPlan'));
    }

    /**
     * Submit claim application.
     */
    public function submitClaim(Request $request)
    {
        $request->validate([
            'plan_unique_id' => 'required|exists:purchased_plans,plan_unique_id',
            'termination_letter' => 'required|file|mimes:pdf,jpg,png,jpeg|max:5120',
            'salary_slips' => 'required|array',
            'salary_slips.*' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',
            'other_documents' => 'nullable|array',
            'other_documents.*' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',
            'remarks' => 'nullable|string',
        ]);

        $purchasedPlan = PurchasedPlan::where('plan_unique_id', $request->plan_unique_id)->firstOrFail();
        $user = auth()->user();

        // Security check
        if ($purchasedPlan->user_id !== $user->id) {
            abort(403);
        }

        // File uploads
        $terminationLetterPath = $request->file('termination_letter')->store('claims/termination_letters', 'public');

        $salarySlipsPaths = [];
        if ($request->hasFile('salary_slips')) {
            foreach ($request->file('salary_slips') as $file) {
                $salarySlipsPaths[] = $file->store('claims/salary_slips', 'public');
            }
        }

        $otherDocsPaths = [];
        if ($request->hasFile('other_documents')) {
            foreach ($request->file('other_documents') as $file) {
                $otherDocsPaths[] = $file->store('claims/other_documents', 'public');
            }
        }

        Claim::create([
            'user_id' => $user->id,
            'plan_id' => $purchasedPlan->plan_id,
            'plan_unique_id' => $purchasedPlan->plan_unique_id,
            'termination_letter' => $terminationLetterPath,
            'salary_slips' => $salarySlipsPaths,
            'other_documents' => $otherDocsPaths,
            'remarks' => $request->remarks,
            'status' => 'pending',
        ]);

        return redirect()->route('customer.claim-management')->with('success', 'Your support request has been submitted successfully.');
    }

    /**
     * Admin: Display all claim requests.
     */
    public function adminClaimRequests()
    {
        // Show ONLY status = pending as per requirements
        $claims = Claim::with(['user', 'plan', 'claimedTransaction'])->where('status', 'pending')->latest()->get();
        return view('admin.claim-requests', compact('claims'));
    }

    /**
     * Admin: Update claim status (Approve/Reject).
     */
    public function updateClaimStatus(Request $request)
    {
        // Check permissions
        if (!hasPermission('claims.approve') && !hasPermission('support.approve')) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        $request->validate([
            'claim_id' => 'required|exists:claims,id',
            'status' => 'required|in:approved,rejected',
        ]);

        $claim = Claim::with(['user', 'plan'])->findOrFail($request->claim_id);

        if ($request->status === 'approved') {
            $request->validate([
                'transaction_screenshot' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'remarks' => 'nullable|string',
            ]);

            try {
                DB::beginTransaction();

                // Store file securely in public/claims (claims/payment_proofs)
                $path = $request->file('transaction_screenshot')->store('claims/payment_proofs', 'public');

                $purchasedPlan = PurchasedPlan::where('plan_unique_id', $claim->plan_unique_id)->first();
                if (!$purchasedPlan) {
                    throw new \Exception('Purchased plan not found for this claim.');
                }

                // Create claimed transaction record
                \App\Models\ClaimedTransaction::create([
                    'claim_request_id' => $claim->id,
                    'user_id' => $claim->user_id,
                    'purchased_plan_id' => $purchasedPlan->id,
                    'plan_id' => $claim->plan_id,
                    'plan_unique_id' => $claim->plan_unique_id,
                    'claim_amount' => $claim->plan->compensation_amount ?? 0,
                    'transaction_screenshot' => $path,
                    'status' => 'approved',
                    'remarks' => $request->remarks,
                    'approved_by' => auth()->id(),
                ]);

                $claim->status = 'approved';
                $claim->save();

                $purchasedPlan->status = 'claimed';
                $purchasedPlan->save();

                DB::commit();

                return response()->json(['success' => 'Claim approved successfully!']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'Unable to approve claim. Please try again. Details: ' . $e->getMessage()], 500);
            }
        } else {
            // Rejection flow
            $claim->status = 'rejected';
            $claim->save();

            return response()->json(['success' => 'Support status updated successfully!']);
        }
    }

    /**
     * Download Repayment History PDF.
     */
    public function downloadPDF($plan_unique_id)
    {
        $user = auth()->user();
        $purchasedPlan = PurchasedPlan::with(['user', 'plan'])
            ->where('plan_unique_id', $plan_unique_id)
            ->firstOrFail();

        // Security check
        if ($user->role_id === 0) {
            // Customer can download ONLY their own
            if ($purchasedPlan->user_id !== $user->id) {
                abort(403, 'Unauthorized access to this membership PDF.');
            }
        } else {
            // Admin/Staff must have permission
            if (!hasPermission('purchased-plans.view', $user)) {
                abort(403, 'Unauthorized access to this membership PDF.');
            }
        }

        $transactions = Transaction::where('plan_unique_id', $plan_unique_id)->latest()->get();

        $pdf = Pdf::loadView('pdf.repayment-history', compact('purchasedPlan', 'transactions'));
        $pdf->setPaper('a4', 'portrait');

        $filename = 'CareerGuard_Repayment_History_' . $purchasedPlan->plan_unique_id . '.pdf';

        return $pdf->download($filename);
    }
}
