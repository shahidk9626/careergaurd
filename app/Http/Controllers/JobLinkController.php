<?php

namespace App\Http\Controllers;

use App\Models\JobLink;
use Illuminate\Http\Request;

class JobLinkController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(JobLink::with('categories')->latest()->get());
        }
        return view('admin.services.job-links.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'job_url' => 'nullable|url',
            'description' => 'nullable|string',
            'contact_person_name' => 'nullable|string|max:255',
            'mobile_number' => 'nullable|string|max:50',
            'job_title' => 'nullable|string|max:255',
            'vacancies' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'salary' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'apply_whatsapp_or_email' => 'nullable|string|max:255',
        ]);

        $job = JobLink::create($request->all());

        if ($request->has('categories')) {
            $job->categories()->sync($request->categories);
        }

        return response()->json(['success' => 'Job link created successfully']);
    }

    public function edit($id)
    {
        return response()->json(JobLink::with('categories')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $job = JobLink::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'job_url' => 'nullable|url',
            'description' => 'nullable|string',
            'contact_person_name' => 'nullable|string|max:255',
            'mobile_number' => 'nullable|string|max:50',
            'job_title' => 'nullable|string|max:255',
            'vacancies' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'salary' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'apply_whatsapp_or_email' => 'nullable|string|max:255',
        ]);

        $job->update($request->all());

        if ($request->has('categories')) {
            $job->categories()->sync($request->categories);
        }

        return response()->json(['success' => 'Job link updated successfully']);
    }

    public function destroy($id)
    {
        $link = JobLink::findOrFail($id);
        $link->delete();
        return response()->json(['success' => 'Job Link deleted successfully!']);
    }

    public function toggleStatus($id)
    {
        $link = JobLink::findOrFail($id);
        $link->status = $link->status === 'active' ? 'inactive' : 'active';
        $link->save();
        return response()->json(['success' => 'Status updated successfully!']);
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:job_links,id',
        ]);

        $count = JobLink::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => "{$count} records deleted successfully."]);
    }
}
