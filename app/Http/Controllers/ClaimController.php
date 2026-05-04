<?php

namespace App\Http\Controllers;

use App\Models\PurchasedPlan;
use App\Models\Transaction;
use App\Models\Claim;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            abort(403, 'Unauthorized access to this plan.');
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
        $query = PurchasedPlan::with(['user', 'plan'])->latest();

        // Role-based filtering
        if ($user->role_id === 0) {
            $query->where('user_id', $user->id);
        }

        // Maturity Condition: current_date >= purchase_date + claim_duration
        // maturity_date = created_at + plan.claim_duration_days
        $plans = $query->get()->filter(function ($purchasedPlan) {
    $purchaseDate = Carbon::parse($purchasedPlan->start_date);
    $claimDuration = $purchasedPlan->plan->claim_duration_days ?? 0;

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
        $purchaseDate = $purchasedPlan->created_at->copy();
        $claimDuration = $purchasedPlan->plan->claim_duration_days ?? 0;
        $maturityDate = $purchaseDate->addDays($claimDuration);

        if (Carbon::now()->lessThan($maturityDate)) {
            return redirect()->back()->with('error', 'This plan has not matured yet.');
        }

        if ($purchasedPlan->status === 'claimed') {
            return redirect()->back()->with('error', 'This plan has already been claimed.');
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

        return redirect()->route('customer.claim-management')->with('success', 'Your claim request has been submitted successfully and is under review.');
    }

    /**
     * Admin: Display all claim requests.
     */
    public function adminClaimRequests()
    {
        $claims = Claim::with(['user', 'plan'])->latest()->get();
        return view('admin.claim-requests', compact('claims'));
    }

    /**
     * Admin: Update claim status (Approve/Reject).
     */
    public function updateClaimStatus(Request $request)
    {
        $request->validate([
            'claim_id' => 'required|exists:claims,id',
            'status' => 'required|in:approved,rejected',
        ]);

        $claim = Claim::findOrFail($request->claim_id);
        $claim->status = $request->status;
        $claim->save();

        if ($request->status === 'approved') {
            $purchasedPlan = PurchasedPlan::where('plan_unique_id', $claim->plan_unique_id)->first();
            if ($purchasedPlan) {
                $purchasedPlan->status = 'claimed';
                $purchasedPlan->save();
            }
        }

        return response()->json(['success' => 'Claim status updated successfully!']);
    }
}
