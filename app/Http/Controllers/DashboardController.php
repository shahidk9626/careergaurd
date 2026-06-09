<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PurchasedPlan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isAdmin = ($user->id === 1) || ($user->role && $user->role->slug === 'admin');

        // 1. Total Active Customers
        $totalActiveCustomers = User::where('role_id', 0)
            ->where('verification_status', 'verified')
            ->where('status', 'active')
            ->count();

        // 2. Total Plans Purchased
        $totalPlansPurchased = PurchasedPlan::count();

        // 3. Total Purchased Amount
        $totalPurchasedAmount = PurchasedPlan::sum('amount');

        // 4. Total Active Staff
        $totalActiveStaff = User::where('role_id', '!=', 0)
            ->whereNotNull('role_id')
            ->where('status', 'active')
            ->where('id', '!=', 1)
            ->count();

        $staffStats = null;
        if (!$isAdmin && $user->role_id !== 0) {
            $baseQuery = PurchasedPlan::where('referred_by', $user->id)
                ->whereHas('plan')
                ->whereExists(function($q) {
                    $q->select(DB::raw(1))
                      ->from('transactions')
                      ->whereColumn('transactions.plan_unique_id', 'purchased_plans.plan_unique_id')
                      ->where('transactions.payment_status', 'success');
                });

            $totalActivePolicies = (clone $baseQuery)->count();
            $totalPremiumGenerated = (clone $baseQuery)->sum('amount');
            
            $overallCommissionEarned = (clone $baseQuery)->get()->sum(function($p) {
                return (float)($p->plan->commission_amount ?? 0);
            });

            $currentMonthQuery = (clone $baseQuery)->whereBetween('start_date', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ]);
            $currentMonthCommission = $currentMonthQuery->get()->sum(function($p) {
                return (float)($p->plan->commission_amount ?? 0);
            });

            $staffStats = [
                'total_active_policies' => $totalActivePolicies,
                'total_premium_generated' => $totalPremiumGenerated,
                'overall_commission_earned' => $overallCommissionEarned,
                'current_month_commission' => $currentMonthCommission
            ];
        }

        return view('dashboard', compact(
            'totalActiveCustomers',
            'totalPlansPurchased',
            'totalPurchasedAmount',
            'totalActiveStaff',
            'staffStats'
        ));
    }
}
