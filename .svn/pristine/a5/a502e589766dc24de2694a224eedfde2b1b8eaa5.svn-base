<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\SubjectSection;
use App\Staff;
use App\SubSectionStudent;
use App\Exam;
use App\StudentMarks;
use DB;
use App\ExamDetails;
use App\ExamSubjectSub;
use App\MarksSubjectSub;

class MarksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!request()->ajax()) {
            return View('exams.index');
        }

        $rules = [
            'teacher_id' => 'required|integer'
        ];
        if ($request->input('course_id', 0) > 0) {
            $rules['course_id'] = 'integer|exists:' . getYearlyDbConn() . '.courses,id';
        }
        $this->validate($request, $rules);

        $subsecs = SubjectSection::orderBy('subject_id')
            ->where('teacher_id', '=', $request->teacher_id);
        if ($request->input('course_id', 0) > 0) {
            $subsecs = $subsecs->where('course_id', '=', $request->course_id);
        }
        return $subsecs->with(['course', 'subject', 'section'])
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStudentMarks()
    {
        return view('exams.student_marks');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveStudentMarks(Request $request)
    {
        $rules = [
            'exam_name'=>'required',
            'semester'=>'required',
            'student_subject.section_id'=>'required|integer|min:1',
            'student_subject.course_id'=>'required|integer|min:1',
            'student_subject.subject_id'=>'required|integer|min:1',
            'min_marks'=>'required',
            'max_marks'=>'required',
            'student_marks'=>'array|min:1',
            'paper_code'=>'required_if:have_sub_papers,Y',
           
            'student_marks.*.std_id'=>'distinct|integer|min:1|exists:' . getYearlyDbConn() .'.students,id,course_id,'.$request->student_subject['course_id'],
        ];
        if ($request->have_sub_papers == 'Y') {
            $rules += ['paper_type'=>'not_in:0'];
        }
        $this->validate(
            $request,
            $rules,
            [
                'student_marks.*.std_id.distinct'=>'Please Enter Unique Roll Numbers',
                'student_marks.*.std_id.min'=>'Please Enter Students Roll Number',
                'student_marks.*.std_id.integer'=>'Please Enter Students Valid roll Number',
                'student_marks.*.std_id.exists'=>'Please Enter a valid Roll Number'
            ]
        );

        $user_id = auth()->user()->id;
        $teacher_id = 0;
        $staff = Staff::where('user_id', $user_id)->first();
        if ($staff) {
            if ($staff->type == 'Teacher') {
                $teacher_id = $staff->id;
            }
        }

        $students = new \Illuminate\Database\Eloquent\Collection();


        $old_ids_sub_sec_det = [];
        $old_ids_marks = [];
        $old_ids_marks_sub = [];

        if ($teacher_id != 0) {
            $subject_sections =  SubjectSection::where('course_id', $request->student_subject['course_id'])
                ->where('subject_id', $request->student_subject['subject_id'])
                ->where('section_id', $request->student_subject['section_id'])->first();

            if ($subject_sections == null) {
                $subject_sections = new SubjectSection();
            } else {
                $subject_sections_dets =  $subject_sections->subSecStudents;
                $old_ids_sub_sec_det = $subject_sections->subSecStudents->pluck('id')->toArray();
                $old_ids_marks = count($subject_sections->marks) > 0 ? $subject_sections->marks->pluck('id')->toArray() : [];
                // $old_ids_marks_sub = count($subject_sections->marks->subPapersMarks) > 0 ? $subject_sections->marks->subPapersMarks->pluck('id')->toArray() : [];
                
                foreach ($subject_sections->marks as $sub_mark) {
                    if ($sub_mark->subPapersMarks) {
                        foreach ($sub_mark->subPapersMarks as $marks_sub) {
                            array_push($old_ids_marks_sub, $marks_sub->id);
                        }
                    }
                }
            }

            $subject_sections->fill($request->student_subject);
            $subject_sections->teacher_id = $teacher_id;
            $subject_sections->students = 0;
      

            $count = 0;
            foreach ($request->student_marks as $student) {
                if ($student['std_id'] > 0) {
                    $count++;
                    if ($subject_sections->id > 0) {
                        $subject_sec_det =  SubSectionStudent::where('sub_sec_id', $subject_sections->id)->where('std_id', $student['std_id'])->first();
                        if ($subject_sec_det == null) {
                            $subject_sec_det =  new SubSectionStudent();
                            $subject_sec_det->std_id = $student['std_id'];
                        }
                    } else {
                        $subject_sec_det =  new SubSectionStudent();
                        $subject_sec_det->std_id = $student['std_id'];
                    }
                    $students->add($subject_sec_det);
                }
            }

            
            $subject_sections->students = $count;
            $exam = Exam::where('semester', $request->semester)->where('exam_name', $request->exam_name)->first();
            if ($exam == null) {
                $exam = new Exam();
                $exam->exam_name = $request->exam_name;
                $exam->semester = $request->semester;
                $exam->exam_type = "";
            }
            if ($exam->id > 0) {
                $exam_detail = ExamDetails::where('exam_id', $exam->id)
                                ->where('course_id', $request->student_subject['course_id'])
                                ->where('subject_id', $request->student_subject['subject_id'])
                                ->first();
                if ($exam_detail == null) {
                    $exam_detail = new ExamDetails();
                    $exam_detail->exam_id = 0;
                }
                $exam_detail->course_id = $request->student_subject['course_id'];
                $exam_detail->subject_id = $request->student_subject['subject_id'];
                if ($request->have_sub_papers == "N") {
                    $exam_detail->min_marks = $request->min_marks;
                    $exam_detail->max_marks = $request->max_marks;
                    $exam_detail->paper_code = $request->paper_code;
                } else {
                    $exam_sub_paper = ExamSubjectSub::where('exam_det_id', $exam_detail->id)->where('paper_code', $request->paper_code)->first();
                    if (!$exam_sub_paper) {
                        $exam_sub_paper = new ExamSubjectSub();
                    }
                    $exam_sub_paper->min_marks = $request->min_marks;
                    $exam_sub_paper->max_marks = $request->max_marks;
                    $exam_sub_paper->paper_code = $request->paper_code;
                    $exam_sub_paper->paper_type = $request->paper_type;
                }
            } else {
                $exam_detail = new ExamDetails();
                $exam_detail->exam_id = 0;
                $exam_detail->course_id = $request->student_subject['course_id'];
                $exam_detail->subject_id = $request->student_subject['subject_id'];
                if ($request->have_sub_papers == "N") {
                    $exam_detail->min_marks = $request->min_marks;
                    $exam_detail->max_marks = $request->max_marks;
                    $exam_detail->paper_code = $request->paper_code;
                } else {
                    $exam_sub_paper = new ExamSubjectSub();
                    $exam_sub_paper->min_marks = $request->min_marks;
                    $exam_sub_paper->max_marks = $request->max_marks;
                    $exam_sub_paper->paper_code = $request->paper_code;
                    $exam_sub_paper->paper_type = $request->paper_type;
                }
            }

            $marks = new \Illuminate\Database\Eloquent\Collection();
            $marks_sub_papers = new \Illuminate\Database\Eloquent\Collection();
            
            
            foreach ($students as $stu) {
                $mark =[];
                $mark_sub = [];
                if ($stu->id > 0) {
                    // $mark = StudentMarks::where('sub_sec_id',$stu->sub_sec_id)->where('exam_det_id',$exam_detail->id)->where('std_id',$stu->std_id)->first();
                    $mark = StudentMarks::where('exam_det_id', $exam_detail->id)->where('std_id', $stu->std_id)->first();
                    if ($mark == null) {
                        $mark = new StudentMarks();
                        $mark->std_id = $stu->std_id;
                    }
                    if ($request->have_sub_papers == 'Y') {
                        if ($exam_sub_paper->id > 0) {
                            $mark_sub = MarksSubjectSub::where('marks_id', $mark->id)
                            ->where('exam_sub_id', $exam_sub_paper->id)
                            ->where('std_id', $stu->std_id)->first();
                        }
                        if ($mark_sub == null) {
                            $mark_sub = new MarksSubjectSub();
                            $mark_sub->std_id = $stu->std_id;
                        }
                    }
                } else {
                    $mark = new StudentMarks();
                    $mark->std_id = $stu->std_id;
                    if ($request->have_sub_papers == 'Y') {
                        $mark_sub = new MarksSubjectSub();
                        $mark_sub->std_id = $stu->std_id;
                    }
                }
                $marks->add($mark);
                $marks_sub_papers->add($mark_sub);
            }

            $new_ids_sub_sec_det =  $students->pluck('id')->toArray();
            $new_ids_marks =  $marks->pluck('id')->toArray();
            $new_ids_marks_sub =  $marks_sub_papers->pluck('id')->toArray();


            $detach_sub_sec_det = array_diff($old_ids_sub_sec_det, $new_ids_sub_sec_det);
            $detach_marks = array_diff($old_ids_marks, $new_ids_marks);
            $detach_mark_sub = array_diff($old_ids_marks_sub, $new_ids_marks_sub);

            DB::beginTransaction();
            $subject_sections->save();
            $subject_sections->subSecStudents()->saveMany($students);
            $exam->save();
            $exam->examDet()->save($exam_detail);
            if ($request->have_sub_papers == "Y") {
                $exam_detail->examSubs()->save($exam_sub_paper);
            }
            foreach ($marks as $stu_marks) {
                $stu_marks->sub_sec_id = $subject_sections->id;
                $stu_marks->exam_det_id = $exam_detail->id;
                foreach ($request->student_marks as $student) {
                    if ($student['std_id'] == $stu_marks->std_id) {
                        if ($request->have_sub_papers == 'Y') {
                            foreach ($marks_sub_papers as $sub_paper) {
                                if ($sub_paper->std_id == $stu_marks->std_id) {
                                    $sub_paper->exam_sub_id = $exam_sub_paper->id;
                                    $sub_paper->marks = $student['marks'];
                                    if ($student['marks'] == '') {
                                        $sub_paper->marks = 0;
                                    }
                                }
                            }
                        } else {
                            $stu_marks->marks  = $student['marks'];
                            if ($student['marks'] == '') {
                                $stu_marks->marks = 0;
                            }
                        }
                        $stu_marks->save();
                        if ($request->have_sub_papers == "Y") {
                            $stu_marks->subPapersMarks()->saveMany($marks_sub_papers);
                        }
                    }
                }
            }
            // SubSectionStudent::whereIn('id',$detach_sub_sec_det)->delete();
            // StudentMarks::whereIn('id',$detach_marks)->delete();
            // MarksSubjectSub::whereIn('id',$detach_mark_sub)->delete();
                
            DB::commit();
            return response()->json(['success' => 'successfully Added', 'marks' => $marks], 200, ['app-status' => 'success']);
        }
        return response()->json(['failed' => 'You are not authorized to add marks.'], 200, ['app-status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('exams.marks_entry');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
