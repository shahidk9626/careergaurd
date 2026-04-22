<?php

namespace App\Http\Controllers;

use App\Models\ResumeTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ResumeTemplateController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $templates = ResumeTemplate::with('categories')->latest()->get();
            return response()->json(['data' => $templates]);
        }
        return view('admin.services.resumes.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_path' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = $request->only(['title', 'description']);
        $data['slug'] = Str::slug($request->title) . '-' . Str::random(5);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('resumes/thumbnails', 'public');
        }

        if ($request->hasFile('file_path')) {
            $data['file_path'] = $request->file('file_path')->store('resumes/templates', 'public');
        }

        $template = ResumeTemplate::create($data);

        if ($request->has('categories')) {
            $template->categories()->sync($request->categories);
        }

        return response()->json(['success' => 'Resume Template created successfully!']);
    }

    public function edit($id)
    {
        $template = ResumeTemplate::with('categories')->findOrFail($id);
        return response()->json($template);
    }

    public function update(Request $request, $id)
    {
        $template = ResumeTemplate::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = $request->only(['title', 'description']);

        if ($request->title !== $template->title) {
            $data['slug'] = Str::slug($request->title) . '-' . Str::random(5);
        }

        if ($request->hasFile('thumbnail')) {
            if ($template->thumbnail)
                Storage::disk('public')->delete($template->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('resumes/thumbnails', 'public');
        }

        if ($request->hasFile('file_path')) {
            if ($template->file_path)
                Storage::disk('public')->delete($template->file_path);
            $data['file_path'] = $request->file('file_path')->store('resumes/templates', 'public');
        }

        $template->update($data);

        if ($request->has('categories')) {
            $template->categories()->sync($request->categories);
        }

        return response()->json(['success' => 'Resume Template updated successfully!']);
    }

    public function destroy($id)
    {
        $template = ResumeTemplate::findOrFail($id);
        $template->delete();
        return response()->json(['success' => 'Resume Template deleted successfully!']);
    }

    public function toggleStatus($id)
    {
        $template = ResumeTemplate::findOrFail($id);
        $template->status = $template->status === 'active' ? 'inactive' : 'active';
        $template->save();
        return response()->json(['success' => 'Status updated successfully!']);
    }
}
