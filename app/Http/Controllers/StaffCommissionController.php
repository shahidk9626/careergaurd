<?php

namespace App\Http\Controllers;

use App\Models\StaffMembershipReferral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffCommissionController extends Controller
{
    /**
     * Display listing of referred memberships
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($request->ajax()) {
            // Admin role sees all referrals, standard staff see only theirs
            $isAdmin = ($user->id === 1) || ($user->role && $user->role->slug === 'admin');

            $query = StaffMembershipReferral::with(['staff', 'customer', 'plan', 'transaction']);

            if (!$isAdmin) {
                $query->where('staff_id', $user->id);
            }

            $referrals = $query->latest()->get();

            $data = $referrals->map(function ($ref) {
                return [
                    'id' => $ref->id,
                    'staff_name' => $ref->staff->name ?? 'N/A',
                    'customer_name' => $ref->customer->name ?? 'N/A',
                    'plan_name' => $ref->plan->name ?? 'N/A',
                    'amount' => $ref->plan ? number_format($ref->plan->premium_amount, 2) : '0.00',
                    'purchase_date' => $ref->created_at->format('Y-m-d H:i'),
                    'payment_status' => $ref->payment_status,
                    'referral_status' => $ref->status,
                    'transaction_id' => $ref->transaction ? ($ref->transaction->transaction_reference ?? 'N/A') : ($ref->payment_status === 'success' ? 'Pending' : 'N/A'),
                ];
            });

            return response()->json(['data' => $data]);
        }

        return view('admin.staff-commission.index');
    }

    /**
     * Cancel or Expire a pending payment order referral link manually
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:cancelled,expired',
        ]);

        $referral = StaffMembershipReferral::findOrFail($id);
        $user = auth()->user();
        $isAdmin = ($user->id === 1) || ($user->role && $user->role->slug === 'admin');

        // Check ownership
        if (!$isAdmin && $referral->staff_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        if ($referral->status !== 'pending') {
            return response()->json(['error' => 'Can only change status of pending referrals.'], 400);
        }

        $referral->update([
            'status' => $request->status,
            'payment_status' => $request->status
        ]);

        return response()->json(['success' => 'Referral status updated successfully.']);
    }
}
