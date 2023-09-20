<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdmissionSubjectController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('STUDENT-SUBJECTS'))
            return deny();
        if (!request()->ajax()) {
            $courses = \App\Course::orderBy('sno')
                ->with(['subjects' => function ($q) {
                    $q->where('sub_type', '=', 'C');
                }, 'subjects.subject'])
                ->get(['id', 'course_id', 'course_name']);
            return View('reports.student_subjects', compact('courses'));
        }
        ini_set('memory_limit', '256M');
        $messages = [];
        $rules = [
            'from_date' => 'required',
            'upto_date' => 'required',
        ];
        $this->validate($request, $rules, $messages);
        $students = \App\Student::existing()->notRemoved()
            ->join('courses', 'courses.id', '=', 'students.course_id')->orderBy('courses.sno');

        // ->join('course_subject','course_subject.course_id','=','courses.id')
        // ->where('course_subject.sub_type','=','C');
        if ($request->upto_date == '') {
            $students = $students->where('adm_date', getDateFormat($request->from_date, "ymd"));
        } else
            $students = $students->where('adm_date', '>=', getDateFormat($request->from_date, "ymd"))
                ->where('adm_date', '<=', getDateFormat($request->upto_date, "ymd"));
        if ($request->course_id != 0) {
            $students = $students->where('courses.id', '=', $request->course_id);
        }
        $students = $students->select('students.*', 'course_name');
        return $students->with([
            'admForm' => function ($q) {
                $q->select('id');
            },
            'admEntry' => function ($q) {
                $q->select('id', 'centralized', 'adm_rec_no', 'rcpt_date');
            },
            'stdSubs.subject'
        ])->get();
    }
}
