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

            $data = $request->except(['plan_services']);
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

            $data = $request->except(['plan_services']);
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
}
