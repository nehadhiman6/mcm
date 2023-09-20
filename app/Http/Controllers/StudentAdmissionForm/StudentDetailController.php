<?php

namespace App\Http\Controllers\StudentAdmissionForm;

use App\AdmissionForm;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Online\Controller;
use App\Http\Requests\StudentAdmissionRequests\StudentDetailRequest as StudentDetailRequest;
use Session;
use Illuminate\Http\Request;


class StudentDetailController extends Controller
{
    protected $tab_no = 0;

    private function getCurrentActiveTab()
    {
        $adm = AdmissionForm::whereStdUserId(auth('students')->user()->id)->first();
        return $adm ? $adm->active_tab : 0;
    }

    public function store(StudentDetailRequest $request)
    {
        return $this->saveForm($request);
    }

    private function saveForm($request, $type = 'save')
    {
        $student_detail = AdmissionForm::findOrNew($request->form_id);
        $student_detail->fill($request->all());
        //anil sir will check this
        // if ($student_detail->exists == false && $this->app_guard == 'students' && auth('students')->check()) {
        $student_detail->std_user_id = auth('students')->user()->id;
        // }
        if ($type == 'update')
            $student_detail->active_tab = $this->getCurrentActiveTab();
        $student_detail->save();
        $course = $student_detail->course;
        $course_type = $course->status;
        $compSubs = $student_detail->course->getSubs('C');
        $optionalSubs = $student_detail->course->getSubs('O');
        $compGrps = $student_detail->course->getSubGroups('C');
        $optionalGrps = $student_detail->course->getSubGroups('O');
        $electives = $student_detail->course->getElectives();

        return reply('ok', [
            'active_tab' => $this->getCurrentActiveTab(),
            'form_id' => $student_detail->id,
            'adm_form' => $student_detail,
            'course_type' => $course_type,
            'compSub' => $compSubs,
            'optionalSubs' => $optionalSubs,
            'compGrp' => $compGrps,
            'optionalGrps' => $optionalGrps,
            'electives' => $electives
        ]);
    }


    public function update(StudentDetailRequest $request, $id)
    {
        return $this->saveForm($request, 'update');
    }



    public function printDetail($id)
    {
        //
        $student = \App\AdmissionForm::findOrFail($id);
        return view('admissionform.admprint', compact('students', 'student'));
    }

    public function details($id)
    {
        $adm_form = \App\AdmissionForm::findOrFail($id);
        // dd($adm_form->reservedHostel());
        $adm_form->load('student');
        if (Gate::denies('student-adm-form', $adm_form)) {
            abort('401', 'Resource does not belong to current user!!');
        }
        return view('admissionform.student_detail', compact('adm_form'));
    }
}
