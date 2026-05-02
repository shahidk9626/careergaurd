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
use Carbon\Carbon;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $plans = Plan::latest()->get();
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
            'premium_amount' => 'required|numeric',
            'tenure_type' => 'required|string',
            'tenure_value' => 'nullable|integer',
            'claim_duration_days' => 'required|integer',
            'compensation_amount' => 'required|numeric',
            'status' => 'required|string',
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
            return response()->json(['success' => 'Plan created successfully!']);
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
            'premium_amount' => 'required|numeric',
            'tenure_type' => 'required|string',
            'tenure_value' => 'nullable|integer',
            'claim_duration_days' => 'required|integer',
            'compensation_amount' => 'required|numeric',
            'status' => 'required|string',
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
            return response()->json(['success' => 'Plan updated successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
        return response()->json(['success' => 'Plan deleted successfully!']);
    }

    public function toggleStatus($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->status = $plan->status === 'active' ? 'inactive' : 'active';
        $plan->save();
        return response()->json(['success' => 'Status updated successfully!']);
    }

    /**
     * Public / Preview View
     */
    public function preview()
    {
        $plans = Plan::with('planServices.category')->where('status', 'active')->get();
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
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $user = auth()->user();

        // Access control: role_id = 0 (customer)
        if ($user->role_id != 0) {
            return response()->json(['error' => 'Unauthorized. Only customers can purchase plans.'], 403);
        }

        try {
            DB::beginTransaction();

            $timestamp = time();
            $planUniqueId = $plan->slug . '_' . $user->id . '_' . $timestamp;

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

            // Create Transaction
            Transaction::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'plan_unique_id' => $planUniqueId,
                'amount' => $plan->premium_amount,
                'payment_status' => 'success',
                'payment_method' => 'manual',
            ]);

            // Create Purchased Plan
            PurchasedPlan::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'plan_unique_id' => $planUniqueId,
                'plan_name' => $plan->name,
                'amount' => $plan->premium_amount,
                'tenure_type' => $plan->tenure_type,
                'tenure_value' => $plan->tenure_value,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'active',
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Plan purchased successfully!',
                'redirect' => route('customer.plan-preview')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Purchase failed: ' . $e->getMessage()], 500);
        }
    }
}
