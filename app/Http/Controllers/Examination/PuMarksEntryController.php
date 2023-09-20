<?php

namespace App\Http\Controllers\Examination;

use App\CourseSubject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Examination\PuExamStudent;
use App\Models\Examination\PuMarks;
use App\Student;
use App\StudentSubs;
use Gate;

class PuMarksEntryController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('pu-marks-entry')) {
            return deny();
        }
        if ($request->ajax()) {
            // dd($request->all());
            $this->validateForm($request);

            $exam = $request->exam;
            $type = $request->type;
            $roll_no = $request->college_roll_no;
            $uni_roll_no = $request->uni_roll_no;
            if ($roll_no != '') {
                $student = Student::where('roll_no', $roll_no)->first();
            } else {
                $student = Student::where('pu_regno', $uni_roll_no)->orwhere('pu_regno2', $uni_roll_no)->first();
            }

            $sub_ids = StudentSubs::where('student_id', $student->id)->pluck('subject_id')->toArray();
            if (count($sub_ids) > 0) {
                $subj_ids = CourseSubject::where('course_id', $student->course_id)
                    ->where(function ($where) use ($sub_ids) {
                        $where->where('course_subject.sub_type', '=', 'C')
                            ->orWhereIn('course_subject.subject_id', $sub_ids);
                    })->pluck('subject_id', 'subject_id')->toArray();
            } else {
                $subj_ids = CourseSubject::where('course_id', $student->course_id)->pluck('subject_id', 'subject_id')->toArray();
            }
            $subj_ids += Student::join('admission_entries', 'students.admission_id', '=', 'admission_entries.admission_id')
                ->where('students.id', $student->id)->pluck('admission_entries.honour_sub_id', 'admission_entries.honour_sub_id')->toArray();

            $data = Student::join('courses', 'students.course_id', '=', 'courses.id')
                ->Join('pu_exams', 'students.course_id', '=', 'pu_exams.course_id')
                ->Join('pu_exam_dets', 'pu_exam_dets.pu_exam_id', '=', 'pu_exams.id')
                ->Join(getSharedDb() . 'subjects', 'pu_exam_dets.subject_id', '=', 'subjects.id')
                ->leftJoin('pu_marks', function ($join) {
                    $join->on('students.id', '=', 'pu_marks.std_id')
                        ->on('pu_exam_dets.id', '=', 'pu_marks.pu_exam_det_id');
                })->leftJoin('pu_exam_students', function ($join) {
                    $join->on('students.id', '=', 'pu_exam_students.std_id')
                        ->on('pu_exams.id', '=', 'pu_exam_students.pu_exam_id');
                })
                ->where('pu_exams.exam_name', '=', $exam)
                ->where('courses.status', '=', $type)
                ->whereIn('subjects.id', $subj_ids)
                ->select([
                    'subjects.subject', 'students.name', 'students.id as std_id', 'students.roll_no', 'students.pu_regno', 'students.pu_regno2',
                    'students.father_name', 'students.pupin_no', 'pu_exams.exam_name', 'pu_exams.*', 'pu_exams.id as pu_exam_id', 'pu_exam_dets.*', 'pu_exam_dets.id as pu_exam_det_id', 'courses.course_name',
                    // 'pu_exam_dets.min_marks','pu_exam_dets.max_marks'
                    'pu_marks.marks', 'pu_marks.compartment', 'fail', 'uni_agregate', 'remarks','pu_exam_students.id as pu_exam_std_id'
                ]);
            if ($roll_no) {
                $data = $data->where('students.roll_no', '=', $roll_no);
            }
            if ($uni_roll_no) {
                $data = $data->where(function ($where) use ($uni_roll_no) {
                    // dd($where);
                    $where->where('students.pu_regno', '=', $uni_roll_no)
                        ->orWhere('students.pu_regno2', '=', $uni_roll_no);
                });
            }
            $data = $data->get();
            return reply(true, [
                'data' => $data,
            ]);
        }
        return view('examinations.pu_mark_entry');
    }

    public function validateForm($request)
    {
        // dd($request->all());
        $rules = [
            'exam' => 'required',
            'type' => 'required',


        ];
        $messages = [];

        if ($request->college_roll_no == null && $request->uni_roll_no == null) {

            $rules = [
                'gen_msg' => 'required'
            ];
            $messages = [
                'gen_msg.required' => 'College roll no or Uni Roll no One field is required',
            ];
        }

        $this->validate($request, $rules, $messages);
    }

    public function savePuExamStudent(Request $request)
    {
        // dd($request->pu_exam_id);
        $pu_exam =  PuExamStudent::findOrNew($request->id);
        $pu_exam->fill($request->all());
        $pu_exam->save();
        return reply(true, [
            'pu_exam' => $pu_exam,
        ]);
    }

    public function store(Request $request)
    {
        $this->validateMarksForm($request);
        $mark = PuMarks::firstOrNew(['pu_exam_det_id' => $request->pu_exam_det_id, 'std_id' => $request->std_id]);
        $mark->marks = $request->marks;
        $mark->compartment = $request->compartment;
        $mark->save();
        return reply(true, [
            'mark' => $mark,
        ]);
    }

    public function validateMarksForm($request)
    {
        $key = $request->index;
        $rules = [];
        $messages = [];

        if ($request->max_marks < $request->marks) {

            $rules = [
                'gen_msg.' . $key . '.marks' => 'required'
            ];
            $messages = [
                'gen_msg.' . $key . '.marks.required' => 'Obtain Marks not Greater then Max Marks !',
            ];
        }

        $this->validate($request, $rules, $messages);
    }
}
