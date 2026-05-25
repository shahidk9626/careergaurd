<?php

namespace App\Http\Controllers;

use App\Models\CallbackRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CallbackRequestController extends Controller
{
    /**
     * Store a callback request from the customer.
     */
    public function store(Request $request)
    {
        $request->validate([
            'concern' => 'required|string',
            'flag' => 'required|string|in:direct,purchased,enquiry',
            'purchased_plan_id' => 'nullable|exists:purchased_plans,id',
            'claim_id' => 'nullable|exists:claims,id',
        ]);

        CallbackRequest::create([
            'user_id' => Auth::id(),
            'purchased_plan_id' => $request->purchased_plan_id ?: null,
            'claim_id' => $request->claim_id ?: null,
            'flag' => $request->flag,
            'concern' => $request->concern,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your callback request has been submitted successfully.'
        ]);
    }

    /**
     * Display a listing of callback requests in the admin panel.
     */
    public function adminIndex()
    {
        if (!hasPermission('request-callback.view')) {
            abort(403, 'Unauthorized action.');
        }

        $requests = CallbackRequest::with(['user', 'purchasedPlan', 'claim'])->latest()->get();

        return view('admin.request-callback.index', compact('requests'));
    }

    /**
     * Update the status of a callback request.
     */
    public function updateStatus(Request $request)
    {
        if (!hasPermission('request-callback.status')) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        $request->validate([
            'request_id' => 'required|exists:callback_requests,id',
            'status' => 'required|string|in:pending,contacted,resolved,closed',
        ]);

        $callbackRequest = CallbackRequest::findOrFail($request->request_id);
        $callbackRequest->status = $request->status;
        $callbackRequest->save();

        return response()->json([
            'success' => 'Callback status updated successfully!'
        ]);
    }
}
