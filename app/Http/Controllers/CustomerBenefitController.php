<?php

namespace App\Http\Controllers;

use App\Models\JobLink;
use App\Models\ResumeTemplate;
use App\Models\InterviewQuestion;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerBenefitController extends Controller
{
    public function jobLinks(Request $request)
    {
        $user = auth()->user();
        if (!$user->hasBenefitAccess('job-link')) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this benefit.');
        }

        $request->validate([
            'keyword'     => 'nullable|string|max:100',
            'location'    => 'nullable|string|max:100',
            'city'        => 'nullable|string|max:100',
            'state'       => 'nullable|string|max:100',
            'experience'  => 'nullable|string|max:100',
            'category_id' => 'nullable|integer',
            'sort'        => 'nullable|string|in:latest,salary,relevant',
            'page'        => 'nullable|integer',
        ]);

        $allowedCategoryIds = $user->getActivePurchasedPlanCategories('job-link');

        $query = JobLink::where('status', 'active')
            ->whereHas('categories', function ($q) use ($allowedCategoryIds) {
                $q->whereIn('service_categories.id', $allowedCategoryIds);
            });

        $jobs = $query->with('categories')->get();

        if ($request->filled('keyword')) {
            $keyword = strtolower($request->keyword);
            $jobs = $jobs->filter(function ($job) use ($keyword) {
                return str_contains(strtolower($job->title), $keyword) ||
                       str_contains(strtolower($job->company_name), $keyword) ||
                       str_contains(strtolower($job->description), $keyword);
            });
        }

        if ($request->filled('location')) {
            $location = strtolower($request->location);
            $jobs = $jobs->filter(function ($job) use ($location) {
                return str_contains(strtolower($job->location), $location);
            });
        }

        if ($request->filled('city')) {
            $city = strtolower($request->city);
            $jobs = $jobs->filter(function ($job) use ($city) {
                return str_contains(strtolower($job->city), $city);
            });
        }

        if ($request->filled('state')) {
            $state = strtolower($request->state);
            $jobs = $jobs->filter(function ($job) use ($state) {
                return str_contains(strtolower($job->state), $state);
            });
        }

        if ($request->filled('experience')) {
            $experience = strtolower($request->experience);
            $jobs = $jobs->filter(function ($job) use ($experience) {
                return str_contains(strtolower($job->experience), $experience);
            });
        }

        if ($request->filled('category_id')) {
            $categoryId = intval($request->category_id);
            $jobs = $jobs->filter(function ($job) use ($categoryId) {
                return $job->categories->pluck('id')->contains($categoryId);
            });
        }

        $sort = $request->get('sort', 'latest');
        if ($sort === 'latest') {
            $jobs = $jobs->sortByDesc('created_at');
        } elseif ($sort === 'salary') {
            $jobs = $jobs->sortByDesc(function ($job) {
                return $job->id % 5;
            });
        } else {
            $jobs = $jobs->sortByDesc('id');
        }

        $page    = intval($request->get('page', 1));
        $perPage = 10;
        $paginatedJobs = new LengthAwarePaginator(
            $jobs->forPage($page, $perPage)->values(),
            $jobs->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $categories = ServiceCategory::whereIn('id', $allowedCategoryIds)->where('status', 'active')->get();

        return view('customer.job-links', [
            'jobs'       => $paginatedJobs,
            'categories' => $categories,
        ]);
    }

    public function resumeTemplates(Request $request)
    {
        $user = auth()->user();
        if (!$user->hasBenefitAccess('resume')) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this benefit.');
        }

        $request->validate([
            'keyword'     => 'nullable|string|max:100',
            'category_id' => 'nullable|integer',
            'page_size'   => 'nullable|integer|in:9,18,36',
            'page'        => 'nullable|integer',
        ]);

        $allowedCategoryIds = $user->getActivePurchasedPlanCategories('resume');

        $query = ResumeTemplate::where('status', 'active')
            ->whereHas('categories', function ($q) use ($allowedCategoryIds) {
                $q->whereIn('service_categories.id', $allowedCategoryIds);
            });

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('category_id')) {
            $categoryId = intval($request->category_id);
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('service_categories.id', $categoryId);
            });
        }

        $pageSize  = intval($request->get('page_size', 9));
        $templates = $query->with('categories')->latest()->paginate($pageSize);
        $categories = ServiceCategory::whereIn('id', $allowedCategoryIds)->where('status', 'active')->get();

        return view('customer.resume-templates', [
            'templates'  => $templates,
            'categories' => $categories,
        ]);
    }

    public function downloadResumeTemplate($id)
    {
        $user = auth()->user();
        if (!$user->hasBenefitAccess('resume')) {
            abort(403, 'Unauthorized benefit access');
        }

        $template = ResumeTemplate::findOrFail($id);
        $allowedCategoryIds = $user->getActivePurchasedPlanCategories('resume');

        $hasCategoryAccess = $template->categories()->whereIn('service_categories.id', $allowedCategoryIds)->exists();
        if (!$hasCategoryAccess) {
            abort(403, 'You do not have access to this template.');
        }

        $filePath = $template->file_path;
        if ($filePath && Storage::disk('public')->exists($filePath) && strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) === 'docx') {
            return response()->download(Storage::disk('public')->path($filePath), $template->slug . '.docx');
        }

        $tempFile = tempnam(sys_get_temp_dir(), 'docx');
        $zip = new \ZipArchive();
        if ($zip->open($tempFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            $zip->addFromString('[Content_Types].xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/></Types>');
            $zip->addFromString('_rels/.rels', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/></Relationships>');
            $zip->addFromString('word/document.xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"><w:body><w:p><w:r><w:t>CareerGuard Premium Resume Template: ' . htmlspecialchars($template->title) . '</w:t></w:r></w:p><w:p><w:r><w:t>Category: ' . htmlspecialchars($template->categories->pluck('name')->first() ?? 'General') . '</w:t></w:r></w:p><w:p><w:r><w:t>Description: ' . htmlspecialchars($template->description ?? 'Premium designed resume template for career growth.') . '</w:t></w:r></w:p></w:body></w:document>');
            $zip->close();
        }

        return response()->download($tempFile, $template->slug . '.docx')->deleteFileAfterSend(true);
    }

    public function interviewQuestions(Request $request)
    {
        $user = auth()->user();
        if (!$user->hasBenefitAccess('question')) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this benefit.');
        }

        $allowedCategoryIds = $user->getActivePurchasedPlanCategories('question');

        $categories = ServiceCategory::whereIn('id', $allowedCategoryIds)
            ->where('status', 'active')
            ->withCount(['interviewQuestions' => function ($q) {
                $q->where('status', 'active');
            }])
            ->get();

        $questions = InterviewQuestion::where('status', 'active')
            ->whereHas('categories', function ($q) use ($allowedCategoryIds) {
                $q->whereIn('service_categories.id', $allowedCategoryIds);
            })
            ->get();

        $techCounts = $questions->groupBy('technology')->map(function ($group) {
            return $group->count();
        });

        return view('customer.interview-questions', [
            'categories' => $categories,
            'techCounts' => $techCounts,
        ]);
    }

    public function interviewQuestionsCategory($id, Request $request)
    {
        $user = auth()->user();
        if (!$user->hasBenefitAccess('question')) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this benefit.');
        }

        $allowedCategoryIds = $user->getActivePurchasedPlanCategories('question');
        if (!$allowedCategoryIds->contains($id)) {
            abort(403, 'You do not have access to this category.');
        }

        $category = ServiceCategory::where('status', 'active')->findOrFail($id);

        $request->validate([
            'search'     => 'nullable|string|max:100',
            'technology' => 'nullable|string|max:100',
            'difficulty' => 'nullable|string|in:Easy,Medium,Hard',
            'page'       => 'nullable|integer',
        ]);

        $query     = $category->interviewQuestions()->where('status', 'active');
        $questions = $query->with('categories')->get();

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $questions = $questions->filter(function ($q) use ($search) {
                return str_contains(strtolower($q->title), $search) ||
                       str_contains(strtolower($q->question_text), $search) ||
                       str_contains(strtolower($q->answer_text), $search);
            });
        }

        if ($request->filled('technology')) {
            $technology = strtolower($request->technology);
            $questions  = $questions->filter(function ($q) use ($technology) {
                return strtolower($q->technology) === $technology;
            });
        }

        if ($request->filled('difficulty')) {
            $difficulty = strtolower($request->difficulty);
            $questions  = $questions->filter(function ($q) use ($difficulty) {
                return strtolower($q->difficulty) === $difficulty;
            });
        }

        $allCategoryQuestions = $category->interviewQuestions()->where('status', 'active')->get();
        $technologies         = $allCategoryQuestions->pluck('technology')->unique()->values();

        $page    = intval($request->get('page', 1));
        $perPage = 10;
        $paginatedQuestions = new LengthAwarePaginator(
            $questions->forPage($page, $perPage)->values(),
            $questions->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('customer.interview-questions-category', [
            'category'     => $category,
            'questions'    => $paginatedQuestions,
            'technologies' => $technologies,
        ]);
    }
}