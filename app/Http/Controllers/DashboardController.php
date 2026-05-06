<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PurchasedPlan;

class DashboardController extends Controller
{
    public function index()
    {
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

        return view('dashboard', compact(
            'totalActiveCustomers',
            'totalPlansPurchased',
            'totalPurchasedAmount',
            'totalActiveStaff'
        ));
    }
}
