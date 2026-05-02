<?php

namespace App\Http\Controllers;

use App\Models\PurchasedPlan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
            $purchaseDate = $purchasedPlan->created_at->copy();
            $claimDuration = $purchasedPlan->plan->claim_duration_days ?? 0;
            $maturityDate = $purchaseDate->addDays($claimDuration);
            
            return Carbon::now()->greaterThanOrEqualTo($maturityDate);
        });

        return view('customer.claim-management', compact('plans'));
    }

    /**
     * Process a claim request.
     */
    public function processClaim(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:purchased_plans,id'
        ]);

        $purchasedPlan = PurchasedPlan::with('plan')->findOrFail($request->id);
        $user = auth()->user();

        // Security check
        if ($user->role_id === 0 && $purchasedPlan->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        // Maturity check
        $purchaseDate = $purchasedPlan->created_at;
        $claimDuration = $purchasedPlan->plan->claim_duration_days ?? 0;
        $maturityDate = $purchaseDate->copy()->addDays($claimDuration);

        if (Carbon::now()->lessThan($maturityDate)) {
            return response()->json(['error' => 'This plan has not matured yet.'], 400);
        }

        if ($purchasedPlan->status === 'claimed') {
            return response()->json(['error' => 'This plan has already been claimed.'], 400);
        }

        $purchasedPlan->status = 'claimed';
        $purchasedPlan->save();

        return response()->json(['success' => 'Claim processed successfully!']);
    }
}
