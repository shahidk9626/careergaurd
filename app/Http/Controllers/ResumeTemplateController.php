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
            'title'     => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_path' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = $request->only(['title', 'description']);
        $data['slug'] = Str::slug($request->title) . '-' . Str::random(5);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->uploadFile($request->file('thumbnail'), 'uploads/resumes/thumbnails');
        }

        if ($request->hasFile('file_path')) {
            $data['file_path'] = $this->uploadFile($request->file('file_path'), 'uploads/resumes/templates');
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
            'title'     => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = $request->only(['title', 'description']);

        if ($request->title !== $template->title) {
            $data['slug'] = Str::slug($request->title) . '-' . Str::random(5);
        }

        if ($request->hasFile('thumbnail')) {
            $this->deleteFile($template->thumbnail);
            $data['thumbnail'] = $this->uploadFile($request->file('thumbnail'), 'uploads/resumes/thumbnails');
        }

        if ($request->hasFile('file_path')) {
            $this->deleteFile($template->file_path);
            $data['file_path'] = $this->uploadFile($request->file('file_path'), 'uploads/resumes/templates');
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
        $this->deleteFile($template->thumbnail);
        $this->deleteFile($template->file_path);
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

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:resume_templates,id',
        ]);

        $templates = ResumeTemplate::whereIn('id', $request->ids)->get();
        foreach ($templates as $template) {
            $this->deleteFile($template->thumbnail);
            $this->deleteFile($template->file_path);
            $template->delete();
        }

        return response()->json(['success' => count($templates) . ' records deleted successfully.']);
    }

    // ─── Helpers ────────────────────────────────────────────────────────────────

    /**
     * Move an uploaded file into public/{$folder} and return the relative path.
     * Creates the directory automatically if it doesn't exist.
     */
    private function uploadFile($file, string $folder): string
    {
        $dir = public_path($folder);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $filename);
        return $folder . '/' . $filename;
    }

    /**
     * Delete a file that lives inside public/ (path relative to public/).
     * Silently ignores null or missing files.
     */
    private function deleteFile(?string $path): void
    {
        if ($path && file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    }
}