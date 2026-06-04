<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Plan;
use App\Models\PaymentOrder;
use App\Models\StaffMembershipReferral;
use App\Mail\ReferralPaymentLinkMail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class StaffReferralController extends Controller
{
    /**
     * Membership Selection Page for Staff/Admin
     */
    public function selectMembership(Request $request, $id)
    {
        $customer = User::where('role_id', 0)->findOrFail($id);

        $search = $request->input('search');
        $query = Plan::with('planServices.category')->where('status', 'active');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhereHas('planServices.category', function($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $plans = $query->paginate(9)->withQueryString();

        return view('admin.customers.select-membership', compact('customer', 'plans'));
    }

    /**
     * Generate Cashfree Payment Link & Send Email
     */
    public function generatePaymentLink(Request $request, $id)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'payment_type' => 'nullable|string|in:regular,one_time',
        ]);

        $customer = User::where('role_id', 0)->findOrFail($id);
        $plan = Plan::findOrFail($request->plan_id);
        $staff = auth()->user();

        // Validate customer account conditions (must match existing checkout validation logic)
        if ($customer->profile_completed != 1) {
            return response()->json(['error' => 'Please ask the customer to complete their profile registration first.'], 400);
        }

        if ($customer->verification_status !== 'verified') {
            return response()->json(['error' => 'Customer profile verification is pending admin approval.'], 400);
        }

        if ($customer->status !== 'active') {
            return response()->json(['error' => 'Customer account status is currently inactive.'], 400);
        }

        // Resolve purchase amount
        $amount = $plan->premium_amount;
        if ($request->payment_type === 'one_time' && $plan->one_time_payment_applicable) {
            $amount = $plan->discount_price ?? $plan->one_time_payment_amount;
        }

        // Generate unique order ID starting with REF_ to distinguish referral
        $orderId = 'REF_' . date('Ymd') . '_' . Str::upper(Str::random(6));
        $timestamp = time();
        $planUniqueId = $plan->slug . '_' . $customer->id . '_' . $timestamp;

        try {
            DB::beginTransaction();

            // 1. Create Pending Payment Order record
            $paymentOrder = PaymentOrder::create([
                'order_id' => $orderId,
                'user_id' => $customer->id,
                'plan_id' => $plan->id,
                'plan_unique_id' => $planUniqueId,
                'amount' => $amount,
                'status' => 'pending',
            ]);

            // 2. Call Cashfree API to create order
            $appId = config('services.cashfree.app_id');
            $secretKey = config('services.cashfree.secret_key');
            $baseUrl = config('services.cashfree.base_url');

            if (empty($appId) || empty($secretKey)) {
                throw new \Exception('Cashfree gateway is not configured. Missing App ID or Secret Key.');
            }

            $response = Http::withHeaders([
                'x-client-id' => $appId,
                'x-client-secret' => $secretKey,
                'x-api-version' => '2023-08-01',
                'Content-Type' => 'application/json',
            ])->post($baseUrl . '/orders', [
                'order_id' => $orderId,
                'order_amount' => (float)$amount,
                'order_currency' => 'INR',
                'customer_details' => [
                    'customer_id' => (string)$customer->id,
                    'customer_email' => $customer->email,
                    'customer_phone' => $customer->phone ?? $customer->whatsapp_number ?? '9999999999',
                ],
                'order_meta' => [
                    'return_url' => route('payment-success', ['order_id' => $orderId]),
                    'notify_url' => route('customer.payment.webhook'),
                ]
            ]);

            if ($response->failed()) {
                $errorMessage = $response->json('message') ?? 'Cashfree Order creation failed: ' . $response->body();
                throw new \Exception($errorMessage);
            }

            $responseData = $response->json();
            $paymentSessionId = $responseData['payment_session_id'] ?? null;

            if (empty($paymentSessionId)) {
                throw new \Exception('Failed to generate payment session token from Cashfree.');
            }

            // Update payment order with session ID
            $paymentOrder->update([
                'payment_session_id' => $paymentSessionId,
                'gateway_response' => json_encode($responseData),
            ]);

            // 3. Generate Local Checkout Link
            $paymentLink = route('pay-referral', ['order_id' => $orderId]);

            // 4. Create Referral record
            $referral = StaffMembershipReferral::create([
                'staff_id' => $staff->id,
                'customer_id' => $customer->id,
                'plan_id' => $plan->id,
                'cashfree_order_id' => $orderId,
                'payment_link' => $paymentLink,
                'status' => 'pending',
                'payment_status' => 'pending',
                'expires_at' => Carbon::now()->addHours(24),
            ]);

            // 5. Send email to customer
            Mail::to($customer->email)->send(new ReferralPaymentLinkMail($customer, $plan, $referral, $paymentLink, $staff));

            DB::commit();

            return response()->json([
                'success' => 'Payment link generated and emailed to customer successfully.',
                'order_id' => $orderId,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Staff Referral Order Creation Exception: ' . $e->getMessage(), [
                'exception' => $e,
                'customer_id' => $customer->id,
                'plan_id' => $plan->id,
            ]);

            return response()->json(['error' => 'Failed to initialize payment link: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Public checkout redirect wrapper
     */
    public function payReferral($order_id)
    {
        $referral = StaffMembershipReferral::with(['customer', 'plan'])->where('cashfree_order_id', $order_id)->first();
        if (!$referral) {
            return view('errors.404')->with('message', 'Invalid order details.');
        }

        // Handle Expiry
        if ($referral->status === 'expired' || Carbon::now()->greaterThan($referral->expires_at)) {
            if ($referral->status === 'pending') {
                $referral->update([
                    'status' => 'expired',
                    'payment_status' => 'expired'
                ]);
            }
            return view('customer.plans.pay-referral', [
                'referral' => $referral,
                'error' => 'This payment link has expired. Please ask the representative to generate a new payment link.'
            ]);
        }

        // Handle Paid
        if ($referral->status === 'paid' || $referral->payment_status === 'success') {
            return redirect()->route('payment-success', ['order_id' => $order_id]);
        }

        // Handle Cancelled
        if ($referral->status === 'cancelled') {
            return view('customer.plans.pay-referral', [
                'referral' => $referral,
                'error' => 'This payment request has been cancelled.'
            ]);
        }

        $paymentOrder = PaymentOrder::where('order_id', $order_id)->firstOrFail();

        return view('customer.plans.pay-referral', [
            'referral' => $referral,
            'paymentSessionId' => $paymentOrder->payment_session_id,
            'environment' => config('services.cashfree.env', 'sandbox')
        ]);
    }

    /**
     * Public payment callback / success landing page
     */
    public function paymentSuccess($order_id)
    {
        $paymentOrder = PaymentOrder::where('order_id', $order_id)->firstOrFail();
        $referral = StaffMembershipReferral::with(['customer', 'plan', 'staff'])->where('cashfree_order_id', $order_id)->firstOrFail();

        // Verify status with Cashfree if order is not marked successful in local DB yet
        if ($paymentOrder->status !== 'success') {
            try {
                $appId = config('services.cashfree.app_id');
                $secretKey = config('services.cashfree.secret_key');
                $baseUrl = config('services.cashfree.base_url');

                $orderResponse = Http::withHeaders([
                    'x-client-id' => $appId,
                    'x-client-secret' => $secretKey,
                    'x-api-version' => '2023-08-01',
                    'Content-Type' => 'application/json',
                ])->get($baseUrl . '/orders/' . $order_id);

                if ($orderResponse->successful()) {
                    $orderData = $orderResponse->json();
                    $orderStatus = $orderData['order_status'] ?? null;

                    $paymentsResponse = Http::withHeaders([
                        'x-client-id' => $appId,
                        'x-client-secret' => $secretKey,
                        'x-api-version' => '2023-08-01',
                        'Content-Type' => 'application/json',
                    ])->get($baseUrl . '/orders/' . $order_id . '/payments');

                    $paymentsData = $paymentsResponse->json();
                    $successfulPayment = null;

                    if (is_array($paymentsData)) {
                        foreach ($paymentsData as $pay) {
                            if (($pay['payment_status'] ?? '') === 'SUCCESS') {
                                $successfulPayment = $pay;
                                break;
                            }
                        }
                    }

                    if ($orderStatus === 'PAID' && $successfulPayment) {
                        // Activate payment
                        $planController = new PlanController();
                        $planController->activatePaymentOrder($paymentOrder, $successfulPayment, $orderData);
                        
                        // Reload relations
                        $referral->refresh();
                    } else {
                        if ($paymentOrder->status !== 'success') {
                            $paymentOrder->update(['status' => 'failed']);
                            $referral->update(['payment_status' => 'failed']);
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('Public Success Page Payment Verification Failed: ' . $e->getMessage(), [
                    'order_id' => $order_id,
                ]);
            }
        }

        return view('customer.plans.payment-success', compact('referral'));
    }
}
