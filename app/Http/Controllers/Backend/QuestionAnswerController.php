<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionAnswerController extends Controller
{
     public function questionAnswer()
    {
        $questions = Question::latest()->paginate(10);
        return view('backend.pages.questions.index', compact('questions'));
    }

    public function edit($id)
    {
        $question = Question::findOrFail($id);
        return view('backend.pages.questions.edit', compact('question'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'answer' => 'required|string',
        ]);

        $question = Question::findOrFail($id);
        $question->answer = $request->answer;
        $question->save();

        return redirect()->route('admin.questions.answer')->with('success', 'Answer submitted successfully.');
    }

}
