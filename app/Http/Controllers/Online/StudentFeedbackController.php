<?php

namespace App\Http\Controllers\Online;

use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Online\StudentFeedback;
use App\Http\Controllers\Online\Controller;
use App\Models\Maintenance\FeedbackSection;
use App\Models\Online\StudentFeedbackSuggestion;

class StudentFeedbackController extends Controller
{
    protected $msg = '';
    protected $app_setting = '';

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->app_setting = AppSetting::where('key_name', '=', 'stu_satisfaction_survey')->first();
        if ($this->app_setting) {
            $this->msg = $this->app_setting->description;
        }
    }

    public function index($id)
    {

        if ($this->app_setting && $this->app_setting->key_value == 'Close') {
            return view('errors.503', ['msg' => $this->msg]);
        }
        $adm_form = \App\AdmissionForm::findOrFail($id)->load('course');

        if (Gate::denies('student-adm-form', $adm_form)) {
            return deny('admforms');
        }

        $adm_form->load('student');
        if (Gate::denies('student-adm-form', $adm_form)) {
            abort('401', 'Resource does not belong to current user!!');
        }
        $student_feedback = StudentFeedback::whereStdId($adm_form->student->id)->get();
        $feedback_sections = FeedbackSection::orderBy('sno')->where('under_section_id', '=', 0)
            ->with('feedback_question', 'sub_sections.feedback_question')
            ->get();
        $student_feedback_sugg = StudentFeedbackSuggestion::whereStdId($adm_form->student->id)->get();

        return view('admissionform.student_feedback.index', compact('adm_form', 'feedback_sections', 'student_feedback', 'student_feedback_sugg'));
    }

    public function store(Request $request)
    {
        $rules = [
            'feedback.*.section_id' => 'required|integer|exists:' . getYearlyDbConn() . '.feedback_sections,id',
            'feedback.*.question_id' => 'required|integer|exists:' . getYearlyDbConn() . '.feedback_questions,id',
            'feedback.*.rating' => 'required|in:1,2,3,4,5',
        ];


        if ($request->under_section_id > 0) {
            $rules += [
                'under_section_id' => 'integer|exists:' . getYearlyDbConn() . '.feedback_sections,id',
            ];
        }

        $rules += [
            'suggestion' => 'nullable|max:500',
        ];
        $this->validate($request, $rules);
        foreach ($request->feedback as $data) {
            $std_feedback = StudentFeedback::firstOrNew([
                'section_id' => $request->section_id,
                'under_section_id' => $request->under_section_id,
                'std_id' => $request->std_id,
                'question_id' => $request->question_id
            ]);
            $std_feedback->fill($data);
            $std_feedback->save();
        }
        // dd($request->student_id);
        if ($request->suggestion) {
            $sugg = StudentFeedbackSuggestion::firstOrNew(['std_id' => $request->student_id]);
            $sugg->std_id = $request->student_id;
            $sugg->suggestion = $request->suggestion;
            $sugg->save();
        }

        return reply('OK');
    }
}
