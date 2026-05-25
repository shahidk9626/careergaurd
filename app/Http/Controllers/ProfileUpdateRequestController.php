<?php

namespace App\Http\Controllers;

use App\Models\CustomerUpdateRequest;
use App\Models\User;
use App\Models\CustomerDetail;
use App\Mail\CustomerProfileUpdateRequestApprovedMail;
use App\Mail\CustomerProfileUpdateRequestRejectedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProfileUpdateRequestController extends Controller
{
    /**
     * Admin Side: List Profile Update Requests
     */
    public function index()
    {
        $requests = CustomerUpdateRequest::with(['customer', 'requester'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.profile-update-requests.index', compact('requests'));
    }

    /**
     * Admin Side: Show Update Request Details
     */
    public function show($id)
    {
        $request = CustomerUpdateRequest::with(['customer.customerDetail', 'requester', 'details'])
            ->findOrFail($id);

        return view('admin.profile-update-requests.show', compact('request'));
    }

    /**
     * Admin Side: Approve Profile Update Request
     */
    public function approve($id)
    {
        $updateRequest = CustomerUpdateRequest::findOrFail($id);

        if ($updateRequest->status !== 'pending') {
            return back()->with('error', 'This request is already ' . $updateRequest->status);
        }

        try {
            DB::beginTransaction();

            $user = $updateRequest->customer;
            $customerDetail = $user->customerDetail;

            $userData = [];
            $detailData = [];

            foreach ($updateRequest->details as $detail) {
                $field = $detail->field_name;
                $newValue = $detail->new_value;

                if (in_array($field, ['name', 'phone', 'whatsapp_number'])) {
                    $userData[$field] = $newValue;
                } elseif (in_array($field, ['address', 'city', 'state', 'pincode'])) {
                    $detailData[$field] = $newValue;
                } elseif ($field === 'profile_image') {
                    // Delete old profile image
                    if ($user->profile_image) {
                        Storage::disk('public')->delete($user->profile_image);
                    }

                    // Move profile image from temp to main folder
                    $tempPath = $newValue;
                    $filename = basename($tempPath);
                    $newPath = 'profile_images/' . $filename;

                    if (Storage::disk('public')->exists($tempPath)) {
                        Storage::disk('public')->move($tempPath, $newPath);
                        $userData['profile_image'] = $newPath;
                    }
                }
            }

            // Update user details
            if (!empty($userData)) {
                $user->update($userData);
            }

            // Update customer details
            if (!empty($detailData) && $customerDetail) {
                $customerDetail->update($detailData);
            }

            // Update request status
            $updateRequest->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            // Send notification email to the customer
            try {
                Mail::to($user->email)->send(
                    new CustomerProfileUpdateRequestApprovedMail($user)
                );
            } catch (\Exception $mailEx) {
                Log::error("Failed to send profile update request approval email: " . $mailEx->getMessage());
            }

            DB::commit();
            return redirect()->route('admin.profile-update-requests.show', $id)
                ->with('success', 'Profile update request has been approved and applied successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Admin Side: Reject Profile Update Request
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'remark' => 'required|string|max:1000',
        ], [
            'remark.required' => 'Reason for rejection is required.',
        ]);

        $updateRequest = CustomerUpdateRequest::findOrFail($id);

        if ($updateRequest->status !== 'pending') {
            return back()->with('error', 'This request is already ' . $updateRequest->status);
        }

        try {
            DB::beginTransaction();

            $updateRequest->update([
                'status' => 'rejected',
                'admin_remark' => $request->remark,
            ]);

            $user = $updateRequest->customer;

            // Send notification email to the customer
            try {
                Mail::to($user->email)->send(
                    new CustomerProfileUpdateRequestRejectedMail($user, $request->remark)
                );
            } catch (\Exception $mailEx) {
                Log::error("Failed to send profile update request rejection email: " . $mailEx->getMessage());
            }

            DB::commit();
            return redirect()->route('admin.profile-update-requests.show', $id)
                ->with('success', 'Profile update request has been rejected.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
