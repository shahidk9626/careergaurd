<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanService;
use App\Models\ResumeTemplate;
use App\Models\JobLink;
use App\Models\InterviewQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\PurchasedPlan;
use App\Models\Transaction;
use App\Models\PaymentOrder;
use App\Models\PaymentFailure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $plans = Plan::orderBy('premium_amount', 'asc')->get();
            return response()->json(['data' => $plans]);
        }
        return view('admin.plans.index');
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'premium_amount' => 'required|numeric|min:0',
            'commission_amount' => 'required|numeric|min:0',
            'tenure_type' => 'required|string',
            'tenure_value' => 'nullable|integer|min:0',
            'claim_duration_days' => 'required|integer|min:0',
            'compensation_amount' => 'required|numeric|min:0',
            'status' => 'required|string',
            'prematurity_available' => 'required|boolean',
            'one_time_payment_applicable' => 'required|boolean',
            'one_time_payment_amount' => 'required_if:one_time_payment_applicable,1|nullable|numeric|min:0',
            'discount_price' => 'required_if:one_time_payment_applicable,1|nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except(['plan_services', 'description']);
            $data['short_description'] = $request->description;
            $data['slug'] = Str::slug($request->name) . '-' . Str::random(5);

            $plan = Plan::create($data);

            // Mapping Services with Categories
            if ($request->has('plan_services')) {
                foreach ($request->plan_services as $type => $categories) {
                    foreach ($categories as $categoryId) {
                        PlanService::create([
                            'plan_id' => $plan->id,
                            'service_type' => $type,
                            'service_category_id' => $categoryId,
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json(['success' => 'Membership created successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $plan = Plan::with('planServices')->findOrFail($id);
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'premium_amount' => 'required|numeric|min:0',
            'commission_amount' => 'required|numeric|min:0',
            'tenure_type' => 'required|string',
            'tenure_value' => 'nullable|integer|min:0',
            'claim_duration_days' => 'required|integer|min:0',
            'compensation_amount' => 'required|numeric|min:0',
            'status' => 'required|string',
            'prematurity_available' => 'required|boolean',
            'one_time_payment_applicable' => 'required|boolean',
            'one_time_payment_amount' => 'required_if:one_time_payment_applicable,1|nullable|numeric|min:0',
            'discount_price' => 'required_if:one_time_payment_applicable,1|nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except(['plan_services', 'description']);
            $data['short_description'] = $request->description;
            if ($request->name !== $plan->name) {
                $data['slug'] = Str::slug($request->name) . '-' . Str::random(5);
            }

            $plan->update($data);

            // Re-map Services with Categories
            $plan->planServices()->delete();
            if ($request->has('plan_services')) {
                foreach ($request->plan_services as $type => $categories) {
                    foreach ($categories as $categoryId) {
                        PlanService::create([
                            'plan_id' => $plan->id,
                            'service_type' => $type,
                            'service_category_id' => $categoryId,
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json(['success' => 'Membership updated successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);

        $hasActiveMemberships = \App\Models\PurchasedPlan::where('plan_id', $id)
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->exists();

        if ($hasActiveMemberships) {
            return response()->json([
                'error' => 'This membership plan cannot be deleted because it has active customer subscriptions.'
            ]);
        }

        $plan->delete();
        return response()->json(['success' => 'Membership deleted successfully!']);
    }

    public function toggleStatus($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->status = $plan->status === 'active' ? 'inactive' : 'active';
        $plan->save();
        return response()->json(['success' => 'Status updated successfully!']);
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:plans,id',
        ]);

        $ids = $request->ids;
        $totalSelected = count($ids);
        $deletedCount = 0;
        $skippedCount = 0;

        foreach ($ids as $id) {
            $hasActiveMemberships = \App\Models\PurchasedPlan::where('plan_id', $id)
                ->where('status', 'active')
                ->where('end_date', '>=', now())
                ->exists();

            if ($hasActiveMemberships) {
                $skippedCount++;
            } else {
                $plan = Plan::find($id);
                if ($plan) {
                    $plan->delete();
                    $deletedCount++;
                } else {
                    $skippedCount++;
                }
            }
        }

        return response()->json([
            'success' => true,
            'summary' => [
                'selected' => $totalSelected,
                'deleted' => $deletedCount,
                'skipped' => $skippedCount,
                'message' => "{$totalSelected} plans selected\n{$deletedCount} deleted\n{$skippedCount} skipped because customers have active memberships"
            ]
        ]);
    }

    /**
     * Public / Preview View
     */
    public function preview(Request $request)
    {
        $search = $request->input('search');

        $query = Plan::with('planServices.category')->where('status', 'active')->orderBy('premium_amount', 'asc');

        if ($search) {
    $query->where(function($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('slug', 'like', "%{$search}%")
          ->orWhere('short_description', 'like', "%{$search}%")
          ->orWhereHas('planServices.category', function($cq) use ($search) {
              $cq->where('name', 'like', "%{$search}%");
          });

        // match by amount when the search term is numeric
        if (is_numeric($search)) {
            $q->orWhere('premium_amount', $search)
              ->orWhere('one_time_payment_amount', $search)
              ->orWhere('discount_price', $search);
        }
    });
}

        $plans = $query->paginate(9)->withQueryString();

        return view('admin.plans.preview', compact('plans'));
    }

    public function show($slug)
    {
        $plan = Plan::with('planServices.category')->where('slug', $slug)->firstOrFail();
        return view('customer.plans.show', compact('plan'));
    }

    public function purchase(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'payment_type' => 'nullable|string|in:regular,one_time',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $user = auth()->user();

        // Access control: role_id = 0 (customer)
        if ($user->role_id != 0) {
            return response()->json(['error' => 'Unauthorized. Only customers can purchase memberships.'], 403);
        }

        // Validate customer conditions
        if ($user->status === 'inactive') {
            return response()->json(['error' => 'Your account status is currently inactive.'], 400);
        }

        // Resolve purchase amount
        $amount = $plan->premium_amount;
        if ($request->payment_type === 'one_time' && $plan->one_time_payment_applicable) {
            $amount = $plan->discount_price ?? $plan->one_time_payment_amount;
        }

        // Generate unique order ID: MEM_YYYYMMDD_XXXXXX (format: MEM_Ymd_Str::upper(Str::random(6)))
        $orderId = 'MEM_' . date('Ymd') . '_' . Str::upper(Str::random(6));

        $timestamp = time();
        $planUniqueId = $plan->slug . '_' . $user->id . '_' . $timestamp;

        try {
            DB::beginTransaction();

            // Create Pending Payment Order record
            $paymentOrder = PaymentOrder::create([
                'order_id' => $orderId,
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'plan_unique_id' => $planUniqueId,
                'amount' => $amount,
                'status' => 'pending',
            ]);

            // Call Cashfree API to create order
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
                    'customer_id' => (string)$user->id,
                    'customer_email' => $user->email,
                    'customer_phone' => $user->phone ?? $user->whatsapp_number ?? '9999999999',
                ],
                'order_meta' => [
                    'return_url' => route('customer.payment.callback') . '?order_id=' . $orderId,
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

            // Update payment order with session ID and gateway response
            $paymentOrder->update([
                'payment_session_id' => $paymentSessionId,
                'gateway_response' => json_encode($responseData),
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Order created successfully.',
                'payment_session_id' => $paymentSessionId,
                'order_id' => $orderId,
                'environment' => config('services.cashfree.env', 'sandbox'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log to payment_failures
            PaymentFailure::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'order_id' => $orderId ?? null,
                'error_message' => $e->getMessage(),
                'gateway_response' => isset($response) ? $response->body() : null,
                'status' => 'failed',
            ]);

            Log::error('Cashfree Order Creation Exception: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => $user->id,
                'plan_id' => $plan->id,
            ]);

            return response()->json(['error' => 'Failed to initialize payment: ' . $e->getMessage()], 500);
        }
    }

    public function callback(Request $request)
    {
        $orderId = $request->input('order_id');

        if (empty($orderId)) {
            return redirect()->route('customer.plan-preview')->with('error', 'Invalid order session.');
        }

        $paymentOrder = PaymentOrder::where('order_id', $orderId)->first();
        if (!$paymentOrder) {
            return redirect()->route('customer.plan-preview')->with('error', 'Order not found.');
        }

        // Call Cashfree API to verify payment status
        try {
            $appId = config('services.cashfree.app_id');
            $secretKey = config('services.cashfree.secret_key');
            $baseUrl = config('services.cashfree.base_url');

            // 1. Fetch Order Details from Cashfree
            $orderResponse = Http::withHeaders([
                'x-client-id' => $appId,
                'x-client-secret' => $secretKey,
                'x-api-version' => '2023-08-01',
                'Content-Type' => 'application/json',
            ])->get($baseUrl . '/orders/' . $orderId);

            if ($orderResponse->failed()) {
                throw new \Exception('Failed to fetch order status from Cashfree: ' . $orderResponse->body());
            }

            $orderData = $orderResponse->json();
            $orderStatus = $orderData['order_status'] ?? null;

            // 2. Fetch Payment Details for Order to log transactions
            $paymentsResponse = Http::withHeaders([
                'x-client-id' => $appId,
                'x-client-secret' => $secretKey,
                'x-api-version' => '2023-08-01',
                'Content-Type' => 'application/json',
            ])->get($baseUrl . '/orders/' . $orderId . '/payments');

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
                // Securely activate order
                $this->activatePaymentOrder($paymentOrder, $successfulPayment, $orderData);
                
                // Flash profile status if incomplete or pending approval
                $user = auth()->user();
                if ($user) {
                    $isProfileComplete = $user->profile_completed === 1 && $user->verification_status === 'verified';
                    if (!$isProfileComplete) {
                        session()->flash('profile_incomplete', true);
                    }
                }
                
                return redirect()->route('customer.plan-preview')->with('success', 'Membership purchased successfully');
            } else {
                // Update payment order status to failed
                if ($paymentOrder->status !== 'success') {
                    $paymentOrder->update(['status' => 'failed']);
                }

                // Log payment failure
                PaymentFailure::updateOrCreate(
                    ['order_id' => $orderId],
                    [
                        'user_id' => $paymentOrder->user_id,
                        'plan_id' => $paymentOrder->plan_id,
                        'error_message' => 'Payment status is ' . ($orderStatus ?? 'UNKNOWN') . '. Payment details: ' . json_encode($paymentsData),
                        'gateway_response' => json_encode(['order' => $orderData, 'payments' => $paymentsData]),
                        'status' => 'failed',
                    ]
                );

                return redirect()->route('customer.plan-preview')->with('error', 'Payment failed. Please try again.');
            }

        } catch (\Exception $e) {
            Log::error('Cashfree Verification Exception: ' . $e->getMessage(), [
                'exception' => $e,
                'order_id' => $orderId,
            ]);

            // Log failure
            PaymentFailure::create([
                'user_id' => $paymentOrder->user_id,
                'plan_id' => $paymentOrder->plan_id,
                'order_id' => $orderId,
                'error_message' => $e->getMessage(),
                'gateway_response' => json_encode(['error' => $e->getMessage()]),
                'status' => 'failed',
            ]);

            return redirect()->route('customer.plan-preview')->with('error', 'Payment verification failed: ' . $e->getMessage());
        }
    }

    public function webhook(Request $request)
    {
        $rawBody = $request->getContent();
        $signature = $request->header('X-Webhook-Signature');
        $timestamp = $request->header('X-Webhook-Timestamp');

        Log::info('Cashfree Webhook Received', [
            'timestamp' => $timestamp,
            'signature' => $signature,
            'body' => $rawBody
        ]);

        if (!$signature || !$timestamp) {
            Log::error('Cashfree Webhook signature or timestamp header is missing.');
            return response()->json(['message' => 'Missing signature or timestamp'], 400);
        }

        $secretKey = config('services.cashfree.secret_key');
        
        // Generate computed signature
        $signStr = $timestamp . $rawBody;
        $computedSignature = base64_encode(hash_hmac('sha256', $signStr, $secretKey, true));

        // Compare signatures
        if (!hash_equals($computedSignature, $signature)) {
            Log::error('Cashfree Webhook Signature Mismatch', [
                'received' => $signature,
                'computed' => $computedSignature
            ]);
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        $payload = json_decode($rawBody, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Cashfree Webhook Payload is not valid JSON.');
            return response()->json(['message' => 'Invalid payload format'], 400);
        }

        $eventType = $payload['type'] ?? '';
        $data = $payload['data'] ?? [];
        $orderData = $data['order'] ?? [];
        $paymentData = $data['payment'] ?? [];
        $orderId = $orderData['order_id'] ?? null;

        if (empty($orderId)) {
            Log::error('Cashfree Webhook payload missing order_id.');
            return response()->json(['message' => 'Missing order ID'], 400);
        }

        $paymentOrder = PaymentOrder::where('order_id', $orderId)->first();
        if (!$paymentOrder) {
            Log::warning('Cashfree Webhook: Order not found in database: ' . $orderId);
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($eventType === 'PAYMENT_SUCCESS_WEBHOOK') {
            try {
                $this->activatePaymentOrder($paymentOrder, $paymentData, $orderData);
                return response()->json(['message' => 'Webhook processed successfully'], 200);
            } catch (\Exception $e) {
                Log::error('Cashfree Webhook activation exception: ' . $e->getMessage(), [
                    'exception' => $e,
                    'order_id' => $orderId,
                ]);
                return response()->json(['message' => 'Activation failed: ' . $e->getMessage()], 500);
            }
        } elseif (in_array($eventType, ['PAYMENT_FAILED_WEBHOOK', 'PAYMENT_USER_DROPPED_WEBHOOK'])) {
            if ($paymentOrder->status !== 'success') {
                $paymentOrder->update(['status' => 'failed']);
            }

            // Log failure
            PaymentFailure::updateOrCreate(
                ['order_id' => $orderId],
                [
                    'user_id' => $paymentOrder->user_id,
                    'plan_id' => $paymentOrder->plan_id,
                    'error_message' => 'Failed via Webhook event: ' . $eventType . '. Message: ' . ($paymentData['payment_message'] ?? 'N/A'),
                    'gateway_response' => $rawBody,
                    'status' => 'failed',
                ]
            );

            return response()->json(['message' => 'Failure webhook recorded'], 200);
        }

        return response()->json(['message' => 'Event ignored'], 200);
    }

    public function activatePaymentOrder(PaymentOrder $paymentOrder, array $paymentDetails, array $gatewayResponse)
    {
        // Prevent duplicate processing
        if ($paymentOrder->status === 'success') {
            return;
        }

        $activated = false;

        try {
            DB::transaction(function () use ($paymentOrder, $paymentDetails, $gatewayResponse, &$activated) {
                // Re-fetch with row lock to prevent race conditions
                $paymentOrder = PaymentOrder::where('id', $paymentOrder->id)->lockForUpdate()->first();
                if ($paymentOrder->status === 'success') {
                    return;
                }

                // Update Payment Order Status
                $paymentOrder->update([
                    'status' => 'success',
                    'gateway_response' => json_encode(['order' => $gatewayResponse, 'payment' => $paymentDetails]),
                ]);

                // Check if a staff referral exists for this order
                $referral = \App\Models\StaffMembershipReferral::where('cashfree_order_id', $paymentOrder->order_id)->first();
                $referredBy = null;
                if ($referral) {
                    $referredBy = $referral->staff_id;
                    $referral->update([
                        'status' => 'paid',
                        'payment_status' => 'success'
                    ]);
                }

                // Extract payment method group (e.g. upi, card, netbanking, wallet)
                $paymentMethodString = $paymentDetails['payment_group'] ?? 'cashfree';

                // Convert full Cashfree response into JSON string first
                $jsonResponse = json_encode($paymentDetails);

                // Create Transaction record
                Transaction::updateOrCreate(
                    ['cashfree_order_id' => $paymentOrder->order_id],
                    [
                        'user_id' => $paymentOrder->user_id,
                        'plan_id' => $paymentOrder->plan_id,
                        'plan_unique_id' => $paymentOrder->plan_unique_id,
                        'amount' => $paymentOrder->amount,
                        'payment_status' => 'success',
                        'payment_method' => $paymentMethodString,
                        'transaction_reference' => $paymentDetails['cf_payment_id'] ?? null,
                        'cashfree_order_id' => $paymentOrder->order_id,
                        'cashfree_payment_id' => $paymentDetails['cf_payment_id'] ?? null,
                        'gateway_response' => json_decode($jsonResponse, true),
                    ]
                );

                // Fetch Plan to calculate PurchasedPlan dates
                $plan = Plan::findOrFail($paymentOrder->plan_id);
                
                $startDate = Carbon::now();
                $endDate = null;
                $tenureType = rtrim(strtolower($plan->tenure_type), 's'); // Convert 'months' to 'month', 'days' to 'day'

                if ($tenureType === 'month') {
                    $endDate = $startDate->copy()->addMonths($plan->tenure_value);
                } elseif ($tenureType === 'year') {
                    $endDate = $startDate->copy()->addYears($plan->tenure_value);
                } elseif ($tenureType === 'day') {
                    $endDate = $startDate->copy()->addDays($plan->tenure_value);
                }

                // Create Purchased Membership
                PurchasedPlan::updateOrCreate(
                    ['plan_unique_id' => $paymentOrder->plan_unique_id],
                    [
                        'user_id' => $paymentOrder->user_id,
                        'plan_id' => $paymentOrder->plan_id,
                        'plan_unique_id' => $paymentOrder->plan_unique_id,
                        'plan_name' => $plan->name,
                        'amount' => $paymentOrder->amount,
                        'tenure_type' => $plan->tenure_type,
                        'tenure_value' => $plan->tenure_value,
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'status' => 'active',
                        'referred_by' => $referredBy,
                    ]
                );

                $activated = true;
            });

            if ($activated) {
                // Send MembershipSuccessMail to the customer
                $purchasedPlan = PurchasedPlan::where('plan_unique_id', $paymentOrder->plan_unique_id)->first();
                if ($purchasedPlan) {
                    $user = $purchasedPlan->user;
                    if ($user) {
                        try {
                            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\MembershipSuccessMail($purchasedPlan));
                        } catch (\Exception $mailEx) {
                            Log::error('Failed to send MembershipSuccessMail: ' . $mailEx->getMessage());
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Cashfree Activation Transaction Failed', [
                'error' => $e->getMessage(),
                'order_id' => $paymentOrder->order_id,
            ]);

            // Save exception into payment_failures instead of silently failing
            PaymentFailure::create([
                'user_id' => $paymentOrder->user_id,
                'plan_id' => $paymentOrder->plan_id,
                'order_id' => $paymentOrder->order_id,
                'error_message' => 'Database transaction failed: ' . $e->getMessage(),
                'gateway_response' => json_encode(['payment' => $paymentDetails, 'order' => $gatewayResponse]),
                'status' => 'failed',
            ]);

            throw $e;
        }
    }
}
