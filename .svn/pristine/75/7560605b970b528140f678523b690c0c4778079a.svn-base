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
use App\Student;
use Gate;

class MarksDirectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('STUDENT-MARKS')){
            return deny();
        }
        return view('exams.student_marks');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd("here");
        // $marks = ['id' => 1];
        // return response()->json(['success' => 'successfully Added', 'marks' => $marks], 200, ['app-status' => 'success']);
        
        $courses = Course::where('parent_course_id', $request->student_subject['course_id'])->pluck('id')->toArray();
        array_push($courses, $request->student_subject['course_id']);

        $student = Student::where('id', $request->student['std_id'])->whereIn('course_id', $courses)->first();

        $rules = [
            'exam_name'=>'required',
            'semester'=>'required',
            // 'student.std_id'=>'integer|min:1',
            'student_subject.section_id'=>'required|integer|min:1',
            'student_subject.course_id'=>'required|integer|min:1',
            'student_subject.subject_id'=>'required|integer|min:1',
            'min_marks'=>'required',
            'max_marks'=>'required',
            'student_marks'=>'array|min:1',
            'paper_code'=>'required_if:have_sub_papers,Y',
        ];
        if ($request->have_sub_papers == 'Y') {
            $rules += ['paper_type'=>'not_in:0'];
        }
        if (!$student) {
            $rules += ['invalid_student'=>'required'];
        }

        $user_id = auth()->user()->id;
        $teacher_id = 0;
        $staff = Staff::where('user_id', $user_id)->first();
        if ($staff) {
            if ($staff->type == 'Teacher') {
                $teacher_id = $staff->id;
            }
        }

        $exam = Exam::where('exam_name', '=', $request->exam_name)
            ->where('semester', '=', $request->semester)
            ->firstOrFail();

        $exam_det = ExamDetails::where('exam_id', '=', $exam->id)
            ->where('course_id', '=', $request->student_subject['course_id'])
            ->where('subject_id', '=', $request->student_subject['subject_id'])
            ->firstOrFail();

        $rules += [
            'student.std_id' =>'integer|min:1|unique:'. getYearlyDbConn() .'.marks,std_id,'.$student->id.',std_id,exam_det_id,'.$exam_det->id,
        ];

        $this->validate(
            $request,
            $rules,
            [
                'student_marks.*.std_id.distinct'=>'Please Enter Unique Roll Numbers',
                'student_marks.*.std_id.min'=>'Please Enter Students Roll Number',
                'student_marks.*.std_id.integer'=>'Please Enter Students Valid roll Number',
                'student_marks.*.std_id.exists'=>'Please Enter a valid Roll Number',
            ]
        );
        DB::connection(getYearlyDbConn())->beginTransaction();
        $subject_sec = SubjectSection::firstOrCreate([
            'course_id' => $request->student_subject['course_id'],
            'subject_id' => $request->student_subject['subject_id'],
            'section_id' => $request->student_subject['section_id'],
        ]);
        
        $sub_sec_det = SubSectionStudent::firstOrCreate([
            'sub_sec_id' => $subject_sec->id,
            'std_id' => $request->student['std_id']
        ]);

        $marks = StudentMarks::firstOrCreate([
            'exam_det_id' => $exam_det->id,
            'std_id' => $request->student['std_id'],
            'sub_sec_id' => $subject_sec->id
        ]);

        if ($request->have_sub_papers == 'Y') {
            $exam_subject_sub = ExamSubjectSub::where('exam_det_id', '=', $exam_det->id)
                ->where('paper_type', '=', $request->paper_type)
                ->firstOrFail();
    
            $marks_sub = MarksSubjectSub::firstOrCreate([
                'marks_id' => $marks->id,
                'exam_sub_id' => $exam_subject_sub->id,
                'std_id' => $request->student['std_id'],
            ]);
            $marks_sub->marks = $request->student['marks'];
            $marks_sub->status = $request->student['status'];
            $marks_sub->save();
            $marks = $marks_sub;
        } else {
            $marks->marks = $request->student['marks'];
            $marks->status = $request->student['status'];
            $marks->save();
        }
        DB::connection(getYearlyDbConn())->commit();
        
        return reply('OK', ['marks' => $marks]);

        return response()->json(['failed' => 'You are not authorized to add marks.'], 200, ['app-status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeMarksRecord(Request $request)
    {
        $marks = StudentMarks::findOrFail($request->student['id']);
        // $marks = StudentMarks::where('id',$request->student['id'])->first();
        // return($marks);
        if ($marks) {
            StudentMarks::where('id', $marks->id)->delete();
            $exist_in_another = StudentMarks::where('std_id', $marks->std_id)->where('sub_sec_id', $marks->sub_sec_id)->first();
            if (!$exist_in_another) {
                SubSectionStudent::where('std_id', $marks->std_id)->where('sub_sec_id', $marks->sub_sec_id)->delete();
            }
        }
        return response()->json(['success' => 'successfully Removed'], 200, ['app-status' => 'success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkRecord(Request $request)
    {
        $this->validate($request, [
            'exam_name'=>'required',
            'semester'=>'required',
            'student_subject.section_id'=>'required|integer|min:1',
            'student_subject.course_id'=>'required|integer|min:1',
            'student_subject.subject_id'=>'required|integer|min:1',
        ]);
        $exam = Exam::where('exam_name', $request->exam_name)->where('semester', $request->semester)->first();
        $exam_det = '';
        if ($exam) {
            $exam_det = ExamDetails::where('exam_id', $exam->id)
                        ->where('course_id', $request->student_subject['course_id'])
                        ->where('subject_id', $request->student_subject['subject_id'])->first();
        }
        return response()->json(['success' => 'true','exam_details'=> $exam_det], 200, ['app-status' => 'success']);
    }

    public function showPaper(Request $request)
    {
        $this->validate($request, [
            'exam_name'=>'required',
            'semester'=>'required',
            'student_subject.section_id'=>'required|integer|min:1',
            'student_subject.course_id'=>'required|integer|min:1',
            'student_subject.subject_id'=>'required|integer|min:1',
            'paper_type'=>'required|not_in:0',
        ]);
        $exam = Exam::where('exam_name', $request->exam_name)->where('semester', $request->semester)->first();
        if ($exam) {
            $exam_det = ExamDetails::where('exam_id', $exam->id)
                        ->where('course_id', $request->student_subject['course_id'])
                        ->where('subject_id', $request->student_subject['subject_id'])->first();
            if ($exam_det->have_sub_papers == 'Y') {
                $exam_sub_paper = ExamSubjectSub::where('paper_type', $request->paper_type)
                                    ->where('exam_det_id', $exam_det->id)
                                    ->first();
                return reply('OK', ['paper'=> $exam_sub_paper]);
            } else {
                return reply('OK', ['paper'=> $exam_det]);
            }
        }
    }

    public function show(Request $request)
    {
        $marks =[];
        $rules = [
            'max_marks'=>'required',
            'min_marks'=>'required',
        ];

        if ($request->have_sub_papers == 'Y') {
            $rules+= ['paper_code'=>'required'];
            $rules+= ['paper_type'=>'required|not_in:0'];
        }
        $this->validate($request, $rules);
        $exam = Exam::firstOrCreate($request->only(['exam_name', 'semester']));

        $exam_det = ExamDetails::firstOrCreate([
                'exam_id' => $exam->id,
                'course_id' => $request->student_subject['course_id'],
                'subject_id' => $request->student_subject['subject_id'],
        ], $request->only(['have_sub_papers', 'paper_code', 'min_marks', 'max_marks']));
        
        if (! $exam_det->wasRecentlyCreated) {
            $exam_det->fill($request->only(['have_sub_papers', 'paper_code', 'min_marks', 'max_marks']));
            $exam_det->update();
        }

        if ($exam_det->have_sub_papers == 'Y') {
            $exam_subject_sub = ExamSubjectSub::firstOrCreate([
                'exam_det_id' => $exam_det->id,
                'paper_type' => $request->paper_type,
            ], $request->only(['paper_code', 'max_marks', 'min_marks']));
            if (! $exam_subject_sub->wasRecentlyCreated) {
                $exam_subject_sub->fill($request->only(['max_marks', 'min_marks']));
                $exam_subject_sub->save();
            }
        }
 
        if ($exam_det->have_sub_papers == 'Y' && $request->have_sub_papers == 'N') {
            return response()->json(['success' => 'sub-papers', 'msg' => "This Subject has Sub papers."], 200, ['app-status' => 'success']);
        }
        $subject_sections = SubjectSection::where('course_id', $request->student_subject['course_id'])->where('subject_id', $request->student_subject['subject_id'])
                                ->where('section_id', $request->student_subject['section_id'])->first();

        $students = SubSectionStudent::where('sub_sec_id',$subject_sections->id)
                    ->where('subject_id', $request->student_subject['subject_id'])
                    ->join('students', 'students.id', '=', 'sub_sec_students.std_id')
                    ->orderBy('students.roll_no')
                    ->with(['student'])->get();

        if ($subject_sections) {
            if ($request->have_sub_papers == 'N') {
                $marks = StudentMarks::where('sub_sec_id', $subject_sections->id)
                    ->where('exam_det_id', '=', $exam_det->id)
                    ->with(['examdetail','student'])->get();
            } else {
                $exam_detail_sub = ExamSubjectSub::where('paper_code', $request->paper_code)->where('paper_type', $request->paper_type)
                    ->where('exam_det_id', $exam_det->id)->first();
                if ($request->paper_code == '' && $request->paper_type !== 0) {
                    $exam_detail_sub = ExamSubjectSub::where('paper_type', $request->paper_type)
                    ->where('exam_det_id', $exam->id)->first();
                } else if ($request->paper_code !== '' && $request->paper_type === 0) {
                    $exam_detail_sub = ExamSubjectSub::where('paper_code', $request->paper_code)
                    ->where('exam_det_id', $exam->id)->first();
                }

                if ($exam_detail_sub) {
                    $marks = MarksSubjectSub::where('exam_sub_id', $exam_detail_sub->id)->with(['examdetail','student'])->get();
                }
            }
        }
        return response()->json(['success' => 'true', 'marks' => $marks,'students'=>$students], 200, ['app-status' => 'success']);
    }
}
