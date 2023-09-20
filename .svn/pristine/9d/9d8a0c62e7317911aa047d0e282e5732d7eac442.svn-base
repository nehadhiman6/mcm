<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Maintenance\FeedbackQuestion;
use Gate;

class FeedbackQuestionController extends Controller
{
    public function index()
    {
        if (Gate::denies('FEEDBACK-QUESTIONS')) {
            return deny();
        }
        $feedback_questions = $this->getFeedbackSections();
        return view('maintenance.feedback_question.index', compact('feedback_questions'));
    }

    private function getFeedbackSections()
    {
        return FeedbackQuestion::orderBy('question')->get()->load('feedback_section');
    }

    public function store(Request $request)
    {
        if (Gate::denies('EDIT-FEEDBACK-QUESTIONS')) {
            return deny();
        }
        return $this->saveForm($request, $id=0);
    }

    private function saveForm(Request $request, $id)
    {
        $this->validateForm($request, $id);
        $feedback_question = FeedbackQuestion::findOrNew($id);
        $feedback_question->fill($request->all());
        if ($request->sub_section_id > 0) {
            $feedback_question->section_id = $request->sub_section_id;
        }
        $feedback_question->save();
        return redirect('feedback-questions');
    }

    private function validateForm($request, $id)
    {
        $this->validate($request, [
            'question' => 'required|max:500|unique:' . getYearlyDbConn() . '.feedback_questions,question,' . $id,
            'section_id' => 'required|integer|exists:' . getYearlyDbConn() . '.feedback_sections,id',
            'sno' => 'required|numeric|unique:' . getYearlyDbConn() . '.feedback_questions,sno,' . $id.',id,section_id,'.$request->section_id,
        ]);
    }
    
    public function edit($id)
    {
        if (Gate::denies('EDIT-FEEDBACK-QUESTIONS')) {
            return deny();
        }
        $feedback_questions = $this->getFeedbackSections();
        $feedback_question = FeedbackQuestion::findOrFail($id)->load('feedback_section');
        return view('maintenance.feedback_question.index', compact('feedback_questions', 'feedback_question'));
    }
    
    public function update(Request $request, $id)
    {
        if (Gate::denies('EDIT-FEEDBACK-QUESTIONS')) {
            return deny();
        }
        return $this->saveForm($request, $id);
    }
}
