<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Maintenance\FeedbackSection;
use Gate;

class FeedbackSectionController extends Controller
{
    public function index()
    {
        if (Gate::denies('FEEDBACK-SECTIONS')) {
            return deny();
        }
        $feedback_sections = $this->getFeedbackSections();
        return view('maintenance.feedback_section.index', compact('feedback_sections'));
    }

    private function getFeedbackSections()
    {
        return FeedbackSection::orderBy('name')->get()->load('feedback_section');
    }

    public function store(Request $request)
    {
        if (Gate::denies('EDIT-FEEDBACK-SECTIONS')) {
            return deny();
        }
        return $this->saveForm($request, $id=0);
    }

    private function saveForm(Request $request, $id)
    {
        $this->validateForm($request, $id);
        $feedback_section = FeedbackSection::findOrNew($id);
        $feedback_section->fill($request->all());
        if ($request->under_section_id == null) {
            $feedback_section->under_section_id = 0;
        }
        $feedback_section->save();
        return redirect('feedback-sections');
    }

    private function validateForm($request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:500|unique:' . getYearlyDbConn() . '.feedback_sections,name,' . $id,
            'under_section_id' => 'nullable|integer|exists:' . getYearlyDbConn() . '.feedback_sections,id',
            'sno' => 'required|numeric|unique:' . getYearlyDbConn() . '.feedback_sections,sno,' . $id . ',id,under_section_id,' . $request->under_section_id,
        ]);
    }
    
    public function edit($id)
    {
        if (Gate::denies('EDIT-FEEDBACK-SECTIONS')) {
            return deny();
        }
        $feedback_sections = $this->getFeedbackSections();
        $feedback_section = FeedbackSection::findOrFail($id)->load('feedback_section');
        return view('maintenance.feedback_section.index', compact('feedback_sections', 'feedback_section'));
    }
    
    public function update(Request $request, $id)
    {
        if (Gate::denies('EDIT-FEEDBACK-SECTIONS')) {
            return deny();
        }
        return $this->saveForm($request, $id);
    }
}
