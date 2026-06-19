<?php

namespace App\Http\Controllers;

use App\Models\JobLink;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
            'city'  => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
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
            'city'  => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
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

    public function export(Request $request)
    {
        $ids = $request->input('ids');
        if (is_string($ids)) {
            $ids = json_decode($ids, true);
        }

        $query = JobLink::with('categories')->latest();
        if (is_array($ids) && count($ids) > 0) {
            $query->whereIn('id', $ids);
        }

        $jobs = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'Title', 'Job Title', 'Company Name', 'Location', 'City', 'State', 
            'Salary', 'Experience', 'Vacancies', 'Job URL', 'Contact Person Name', 
            'Mobile Number', 'Apply WhatsApp or Email', 'Categories', 'Description'
        ];
        $sheet->fromArray($headers, null, 'A1');

        $rowNumber = 2;
        foreach ($jobs as $job) {
            $categoryNames = $job->categories->pluck('name')->implode(', ');
            $rowData = [
                $job->title,
                $job->job_title,
                $job->company_name,
                $job->location,
                $job->city,
                $job->state,
                $job->salary,
                $job->experience,
                $job->vacancies,
                $job->job_url,
                $job->contact_person_name,
                $job->mobile_number,
                $job->apply_whatsapp_or_email,
                $categoryNames,
                $job->description,
            ];
            $sheet->fromArray($rowData, null, 'A' . $rowNumber);
            $rowNumber++;
        }

        $writer = new Xlsx($spreadsheet);
        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, 'job_links_export_' . date('Y-m-d_His') . '.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'Title', 'Job Title', 'Company Name', 'Location', 'City', 'State', 
            'Salary', 'Experience', 'Vacancies', 'Job URL', 'Contact Person Name', 
            'Mobile Number', 'Apply WhatsApp or Email', 'Categories', 'Description'
        ];
        $sheet->fromArray($headers, null, 'A1');

        $sampleRow = [
            'Laravel Developer', 'Senior Laravel Developer', 'Acme Corp', 'Bengaluru', 'Bengaluru', 'Karnataka',
            '₹6,00,000 - ₹9,50,000 P.A.', '2-5 Years', '3', 'https://example.com/job', 'John Doe',
            '919876543210', 'apply@example.com', 'IT, Software', 'We are looking for a Laravel developer with experience in API development...'
        ];
        $sheet->fromArray($sampleRow, null, 'A2');

        $writer = new Xlsx($spreadsheet);
        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, 'job_links_template.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file');
        
        try {
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid spreadsheet file: ' . $e->getMessage()], 422);
        }

        if (count($rows) <= 1) {
            return response()->json(['error' => 'The uploaded file has no data rows.'], 422);
        }

        // Remove header row
        array_shift($rows);

        $successCount = 0;
        $parentCategory = ServiceCategory::where('slug', 'job-link')->first();

        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                // Skip completely empty rows or rows without title
                if (empty($row) || !isset($row[0]) || trim($row[0]) === '') {
                    continue;
                }

                // Check if this matches the sample template row exactly, if so, skip it
                if (trim($row[0]) === 'Laravel Developer' && trim($row[2] ?? '') === 'Acme Corp') {
                    continue;
                }

                $job = JobLink::create([
                    'title' => trim($row[0]),
                    'job_title' => isset($row[1]) && trim($row[1]) !== '' ? trim($row[1]) : null,
                    'company_name' => isset($row[2]) && trim($row[2]) !== '' ? trim($row[2]) : null,
                    'location' => isset($row[3]) && trim($row[3]) !== '' ? trim($row[3]) : null,
                    'city' => isset($row[4]) && trim($row[4]) !== '' ? trim($row[4]) : null,
                    'state' => isset($row[5]) && trim($row[5]) !== '' ? trim($row[5]) : null,
                    'salary' => isset($row[6]) && trim($row[6]) !== '' ? trim($row[6]) : null,
                    'experience' => isset($row[7]) && trim($row[7]) !== '' ? trim($row[7]) : null,
                    'vacancies' => isset($row[8]) && trim($row[8]) !== '' ? trim($row[8]) : null,
                    'job_url' => isset($row[9]) && trim($row[9]) !== '' ? trim($row[9]) : null,
                    'contact_person_name' => isset($row[10]) && trim($row[10]) !== '' ? trim($row[10]) : null,
                    'mobile_number' => isset($row[11]) && trim($row[11]) !== '' ? trim($row[11]) : null,
                    'apply_whatsapp_or_email' => isset($row[12]) && trim($row[12]) !== '' ? trim($row[12]) : null,
                    'description' => isset($row[14]) && trim($row[14]) !== '' ? trim($row[14]) : null,
                    'status' => 'active',
                ]);

                if (isset($row[13]) && trim($row[13]) !== '') {
                    $categoryNames = explode(',', $row[13]);
                    $categoryIds = [];
                    foreach ($categoryNames as $catName) {
                        $trimmedName = trim($catName);
                        if (empty($trimmedName)) {
                            continue;
                        }

                        $category = null;
                        if ($parentCategory) {
                            $category = ServiceCategory::where('name', $trimmedName)
                                ->where('parent_id', $parentCategory->id)
                                ->first();
                        }

                        if (!$category && $parentCategory) {
                            // Generate unique slug
                            $slug = Str::slug($trimmedName);
                            $originalSlug = $slug;
                            $count = 1;
                            while (ServiceCategory::where('slug', $slug)->exists()) {
                                $slug = $originalSlug . '-' . $count;
                                $count++;
                            }

                            $category = ServiceCategory::create([
                                'name' => $trimmedName,
                                'slug' => $slug,
                                'parent_id' => $parentCategory->id,
                                'status' => 'active',
                            ]);
                        }

                        if ($category) {
                            $categoryIds[] = $category->id;
                        }
                    }

                    if (!empty($categoryIds)) {
                        $job->categories()->sync($categoryIds);
                    }
                }

                $successCount++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred during import: ' . $e->getMessage()], 500);
        }

        return response()->json(['success' => "{$successCount} jobs imported successfully."]);
    }
}

