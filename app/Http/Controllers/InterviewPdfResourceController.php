<?php

namespace App\Http\Controllers;

use App\Models\InterviewPdfResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InterviewPdfResourceController extends Controller
{
    public function index()
    {
        $pdfs = InterviewPdfResource::with('categories')->latest()->get()->map(function ($pdf) {
            $pdf->created_at_human = $pdf->created_at->format('d M Y');
            return $pdf;
        });
        return response()->json($pdfs);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'pdf_file'    => 'required|file|mimes:pdf|max:10240',
        ]);

        $file     = $request->file('pdf_file');
        $filename = time() . '_' . Str::random(6) . '.pdf';
        $folder   = public_path('uploads/interview-pdfs');
        if (!file_exists($folder)) mkdir($folder, 0755, true);
        $file->move($folder, $filename);

        $pdf = InterviewPdfResource::create([
            'title'       => $request->title,
            'description' => $request->description,
            'file_path'   => 'public/uploads/interview-pdfs/' . $filename,
            'status'      => 'active',
        ]);

        if ($request->has('pdf_categories')) {
            $pdf->categories()->sync($request->pdf_categories);
        }

        return response()->json(['success' => 'PDF resource uploaded successfully!']);
    }

    public function edit($id)
    {
        return response()->json(InterviewPdfResource::with('categories')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $pdf = InterviewPdfResource::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $pdf->update([
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        if ($request->has('pdf_categories')) {
            $pdf->categories()->sync($request->pdf_categories);
        }

        return response()->json(['success' => 'PDF resource updated successfully!']);
    }

    public function destroy($id)
    {
        $pdf = InterviewPdfResource::findOrFail($id);
        if ($pdf->file_path) {
            $cleanPath = \Illuminate\Support\Str::startsWith($pdf->file_path, 'public/') ? substr($pdf->file_path, 7) : $pdf->file_path;
            $fullPath = public_path($cleanPath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
        $pdf->delete();
        return response()->json(['success' => 'PDF deleted successfully!']);
    }

    public function toggleStatus($id)
    {
        $pdf = InterviewPdfResource::findOrFail($id);
        $pdf->status = $pdf->status === 'active' ? 'inactive' : 'active';
        $pdf->save();
        return response()->json(['success' => 'Status updated!']);
    }

    /** Customer-facing: list active PDFs accessible to logged-in user */
    public function customerIndex(Request $request)
    {
        $allowedCategories = auth()->user()->getActivePurchasedPlanCategories('question');

        $query = InterviewPdfResource::where('status', 'active')
            ->whereHas('categories', function ($q) use ($allowedCategories) {
                $q->whereIn('service_categories.id', $allowedCategories);
            });

        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('service_categories.id', $request->category_id);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $pdfs = $query->with('categories')
            ->latest()
            ->get();

        return response()->json($pdfs->map(function ($pdf) {
            return [
                'id'          => $pdf->id,
                'title'       => $pdf->title,
                'description' => $pdf->description,
                'file_url'    => asset($pdf->file_path),
                'categories'  => $pdf->categories,
                'uploaded'    => $pdf->created_at->format('d M Y'),
            ];
        }));
    }
}