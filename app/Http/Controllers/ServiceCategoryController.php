<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(ServiceCategory::latest()->get());
        }
        return view('admin.services.categories.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:service_categories,name',
        ]);

        ServiceCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status ?? 'active',
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

        $request->validate([
            'name' => 'required|string|max:255|unique:service_categories,name,' . $id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status,
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
        ServiceCategory::findOrFail($id)->delete();
        return response()->json(['success' => 'Category deleted successfully']);
    }
}
