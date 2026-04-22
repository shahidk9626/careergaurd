<?php

namespace App\Http\Controllers;

use App\Models\InterviewQuestion;
use Illuminate\Http\Request;

class InterviewQuestionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(InterviewQuestion::with('categories')->latest()->get());
        }
        return view('admin.services.questions.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'question_text' => 'required|string',
            'answer_text' => 'nullable|string',
        ]);

        $question = InterviewQuestion::create($request->all());

        if ($request->has('categories')) {
            $question->categories()->sync($request->categories);
        }

        return response()->json(['success' => 'Question created successfully']);
    }

    public function edit($id)
    {
        return response()->json(InterviewQuestion::with('categories')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $question = InterviewQuestion::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'question_text' => 'required|string',
            'answer_text' => 'nullable|string',
        ]);

        $question->update($request->all());

        if ($request->has('categories')) {
            $question->categories()->sync($request->categories);
        }

        return response()->json(['success' => 'Question updated successfully']);
    }

    public function destroy($id)
    {
        $question = InterviewQuestion::findOrFail($id);
        $question->delete();
        return response()->json(['success' => 'Interview Question deleted successfully!']);
    }

    public function toggleStatus($id)
    {
        $question = InterviewQuestion::findOrFail($id);
        $question->status = $question->status === 'active' ? 'inactive' : 'active';
        $question->save();
        return response()->json(['success' => 'Status updated successfully!']);
    }
}
