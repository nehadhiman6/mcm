<?php

namespace App\Http\Controllers\Examination;

use App\CourseSubject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Examination\PuExamMaster;
use App\Models\Examination\PuMarks;
use Gate;

class PuExamReportController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('pu-exam-report')) {
            return deny();
        }
        if (!request()->ajax()) {
            return view('examinations.pu_exam_report');
        }
        // dd($request->all());
        $rules = [
            'exam' => 'required',
            'course_id' => 'required',
        ];
        $subjects = PuExamMaster::join('pu_exam_dets', 'pu_exams.id', '=', 'pu_exam_dets.pu_exam_id')
            ->join(getSharedDb() . 'subjects', 'subjects.id', '=', 'pu_exam_dets.subject_id')
            ->where('pu_exams.course_id', $request->course_id)->where('pu_exams.exam_name', $request->exam)
            ->select(['pu_exam_dets.id', 'subjects.id as subject_id', 'subjects.subject', 'pu_exam_dets.max_marks'])
            ->orderBy('subjects.subject')->get();
        $pu_exam_det_ids = PuExamMaster::join('pu_exam_dets', 'pu_exams.id', '=', 'pu_exam_dets.pu_exam_id')
            ->where('pu_exams.course_id', $request->course_id)->where('pu_exams.exam_name', $request->exam)
            ->pluck('pu_exam_dets.id')->toArray();
        $data = PuMarks::whereIn('pu_exam_det_id', $pu_exam_det_ids)
            ->select('std_id', 'pu_exam_det_id', 'marks')->orderBy('std_id')->get();
        $data->load('student');

        // roll_no
        // college_roll
        // reg_no
        // name
        // father_name
        // mother_name
        // result
        // max_marks
        // prec_age
        // dd($request->all());
        return compact('data', 'subjects');
    }
}
