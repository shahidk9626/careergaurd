<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ServiceCategory::with('parent');
            
            if ($request->filled('parent')) {
                $parentSlug = $request->parent;
                $query->whereHas('parent', function ($q) use ($parentSlug) {
                    $q->where('slug', $parentSlug);
                });
            } else {
                $query->whereNotIn('slug', ['resume', 'interview', 'job-link']);
            }
            
            return response()->json($query->latest()->get());
        }
        $parentCategories = ServiceCategory::whereIn('slug', ['resume', 'interview', 'job-link'])->get();
        return view('admin.services.categories.index', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $parentId = $request->parent_id;

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('service_categories')->where(function ($query) use ($parentId) {
                    return $query->where('parent_id', $parentId);
                }),
            ],
            'parent_id' => 'nullable|exists:service_categories,id',
        ]);

        $slug = $this->generateUniqueSlug($request->name);

        ServiceCategory::create([
            'name' => $request->name,
            'slug' => $slug,
            'status' => $request->status ?? 'active',
            'parent_id' => $request->parent_id,
        ]);

        return response()->json(['success' => 'Category created successfully']);
    }

    public function edit($id)
    {
        return response()->json(ServiceCategory::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $category = ServiceCategory::findOrFail($id);
        $parentId = $request->parent_id;

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('service_categories')->where(function ($query) use ($parentId) {
                    return $query->where('parent_id', $parentId);
                })->ignore($id),
            ],
            'parent_id' => 'nullable|exists:service_categories,id',
        ]);

        $slug = $this->generateUniqueSlug($request->name, $id);

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'status' => $request->status,
            'parent_id' => $request->parent_id,
        ]);

        return response()->json(['success' => 'Category updated successfully']);
    }

    public function status($id)
    {
        $category = ServiceCategory::findOrFail($id);
        $category->status = $category->status === 'active' ? 'inactive' : 'active';
        $category->save();

        return response()->json(['success' => 'Status updated successfully']);
    }

    public function destroy($id)
    {
        $dependencyError = $this->checkCategoryDependencies($id);
        if ($dependencyError) {
            return response()->json(['error' => $dependencyError]);
        }

        ServiceCategory::findOrFail($id)->delete();
        return response()->json(['success' => 'Category deleted successfully']);
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:service_categories,id',
        ]);

        $ids = $request->ids;
        $totalSelected = count($ids);
        $deletedCount = 0;
        $skippedCount = 0;

        foreach ($ids as $id) {
            $dependencyError = $this->checkCategoryDependencies($id);
            if ($dependencyError) {
                $skippedCount++;
            } else {
                $category = ServiceCategory::find($id);
                if ($category) {
                    $category->delete();
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
                'message' => "{$totalSelected} categories selected\n{$deletedCount} deleted\n{$skippedCount} skipped because they are linked to subcategories, plans, or services"
            ]
        ]);
    }

    private function checkCategoryDependencies($id)
    {
        // 1. Subcategories (parent_id)
        if (ServiceCategory::where('parent_id', $id)->exists()) {
            return 'This category cannot be deleted because it has one or more subcategories assigned.';
        }

        // 2. Plan Services (service_category_id)
        if (\App\Models\PlanService::where('service_category_id', $id)->exists()) {
            return 'This category cannot be deleted because it is linked to one or more membership plans.';
        }

        $category = ServiceCategory::find($id);
        if ($category) {
            // 3. Resume Templates
            if ($category->resumeTemplates()->exists()) {
                return 'This category cannot be deleted because it is linked to one or more resume templates.';
            }

            // 4. Job Links
            if ($category->jobLinks()->exists()) {
                return 'This category cannot be deleted because it is linked to one or more job links.';
            }

            // 5. Interview Questions
            if ($category->interviewQuestions()->exists()) {
                return 'This category cannot be deleted because it is linked to one or more interview questions.';
            }
        }

        return null;
    }

    private function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (true) {
            $query = ServiceCategory::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
            if (!$query->exists()) {
                break;
            }
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
