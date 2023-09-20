<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExamDetails;
use App\Exam;
use App\MarksSubjectSub;
use App\StudentMarks;
use App\Student;
use Gate;

class MarksReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getClasswiseReport(Request $request)
    {
        if (Gate::denies('MARKS-REPORT-CLASS-WISE')) {
            return deny();
        }
        return view('marksreport.classwise_report');
    }

    public function getStudentReport(Request $request)
    {
        if (Gate::denies('MARKS-REPORT-STUDENT-WISE')) {
            return deny();
        }
        return view('marksreport.studentwise_report');
    }

    public function classwiseMarksReport(Request $request)
    {
        $this->validate($request,[
            'semester'=> 'required',
            'exam_name'=>'required',
            'semester'=>'required',
            'course_id'=>'required|integer|min:1',
        ],
        [
            'course_id.min'=>'The Course Field is required',
            'subject_id.min'=>'The Subject Field is required',
        ]);

        $exam = Exam::where('exam_name', $request->exam_name)->where('semester',$request->semester)->first();
        $exam_id = $exam->id;
        $exam_detail = ExamDetails::where('exam_id',$exam_id)->where('course_id',$request->course_id)->get();
        $exam_detail->load('subject');
        
        // $marks = StudentMarks::orderBy('marks.std_id')
        //     ->join('exam_details', 'exam_details.id', '=', 'marks.exam_det_id')
        //     ->where('exam_details.exam_id', '=', $exam_id)
        //     ->where('exam_details.course_id', '=', $request->course_id)
        //      ->with(['student'])
            // ;

        $student = Student::orderBy('students.id')
            ->join('marks', 'students.id', '=', 'marks.std_id')
            ->join('exam_details', 'exam_details.id', '=', 'marks.exam_det_id')
            ->where('exam_details.exam_id', '=', $exam_id)
            ->where('exam_details.course_id', '=', $request->course_id)
            ->select('students.*')->distinct()->with('marks_details.examdetail.subject','marks_details.subPapersMarks')
            ->get();

        return reply('OK', [
            // 'marks'=> $marks->select('marks.*')->get(),
            'students'=>$student,
            'details'=>$exam_detail
        ]);
        
            
    }

    public function studentMarksReport(Request $request)
    {
        if (Gate::denies('MARKS-REPORT-STUDENT-WISE')) {
            return deny();
        }
        $this->validate($request,[
            'semester'=> 'required',
            'exam_name'=>'required',
            'semester'=>'required',
            'roll_no'=>'required',
            'course_id'=>'required|integer|min:1',
        ],
        [
            'course_id.min'=>'The Course Field is required',
            'subject_id.min'=>'The Subject Field is required',
        ]);

        $student = Student::where('roll_no',$request->roll_no)->first();
        if(!$student || $student->course_id != $request->course_id){
            return reply('OK', [
                'student'=>'invalid',
            ]);
        }

        $exam = Exam::where('exam_name', $request->exam_name)->where('semester',$request->semester)->first();
        $exam_id = $exam->id;
        $exam_detail = ExamDetails::where('exam_id',$exam_id)->where('course_id',$request->course_id)->get();
        $exam_detail->load('subject');
        
        $student = Student::where('roll_no',$request->roll_no)
        ->join('marks', 'students.id', '=', 'marks.std_id')
        ->join('exam_details', 'exam_details.id', '=', 'marks.exam_det_id')
        ->join(getSharedDb() .'subjects', 'subjects.id', '=', 'exam_details.subject_id')
        ->where('exam_details.exam_id', '=', $exam_id)
        ->where('exam_details.course_id', '=', $request->course_id)
        ->select('students.*','exam_details.min_marks','exam_details.max_marks','subjects.uni_code','marks.status','marks.id as marks_id','exam_details.have_sub_papers','exam_details.id as exam_det_id')->with('marks_details.examdetail.subject','marks_details.subPapersMarks')
        ->get();

        return reply('OK', [
            // 'marks'=> $marks->select('marks.*')->get(),
            'student'=>$student,
            'details'=>$exam_detail
        ]);


    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function subjectwiseMarksReport(Request $request)
    {
        if (Gate::denies('MARKS-REPORT-SUBJECT-WISE')) {
            return deny();
        }
        return view('marksreport.subjectwise_report');
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
