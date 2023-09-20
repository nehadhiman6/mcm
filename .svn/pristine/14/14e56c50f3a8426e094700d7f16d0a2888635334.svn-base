<?php

namespace App\Http\Controllers;

use App\Exam;
use App\ExamDetails;
use App\Mail\SendStudentResultEmail;
use App\Student;
use App\StudentMarks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Gate;

class SendStudentResultController extends Controller
{
    protected $exam_detail;

    public function index(Request $request)
    {
        if (Gate::denies('send-stu-result-email')) {
            return deny();
        }
        if(!$request->ajax())
        {
            return view('messages.send_stu_result_email.index');
        }

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
        // dd($request->all());
        $exam = Exam::where('exam_name', $request->exam_name)->where('semester',$request->semester)->first();
        $exam_id = $exam->id;
        $exam_detail = ExamDetails::where('exam_id',$exam_id)->where('course_id',$request->course_id)->get();
        $exam_detail->load('subject');
        $students = Student::orderBy('students.id')
            ->join('marks', 'students.id', '=', 'marks.std_id')
            ->join('exam_details', 'exam_details.id', '=', 'marks.exam_det_id')
            ->join(getSharedDb() .'subjects', 'subjects.id', '=', 'exam_details.subject_id')
            ->where('exam_details.exam_id', '=', $exam_id)
            ->where('exam_details.course_id', '=', $request->course_id)
            ->select('students.*')->distinct()->with('std_user','marks_details.examdetail.subject','marks_details.subPapersMarks','marks_details.examdetail.exams')
            ->get();

        // 
        foreach($students as $key=>$std){
            $result = '';
            foreach($std['marks_details'] as $marks_detail){
                    if($marks_detail->examdetail->exams->semester == $request->semester && $marks_detail->examdetail->exams->exam_name == $request->exam_name){
                        $min_marks = $marks_detail->examdetail->min_marks;
                        if($marks_detail->examdetail->have_sub_papers == 'Y'){
                            // if($marks_detail->sub_papers_marks){
                                if($marks_detail->sub_papers_marks && count($marks_detail->sub_papers_marks) > 0){
                                    $marks = 0;
                                    foreach($marks_detail->sub_papers_marks as $ele){
                                        $marks .= floatval($ele->marks);
                                    }
                                    if(floatval($min_marks) > floatval($marks)){
                                        $result != ""? $result .=', ':'';
                                        $result .=  $marks_detail->examdetail->subject->uni_code;
                                    }
                                }
                            // }
                            
                        }
                        else{
                            if(floatval($min_marks) > floatval($marks_detail->marks)){
                                $result != ""? $result .=', ':'';
                                $result .=  $marks_detail->examdetail->subject->uni_code;
                            }
                        }
                    }
                    
                // }
                
                
                    // if($marks_detail['examdetail']->have_sub_papers == 'N'){
                    //     if(floatval($marks_detail['examdetail']->min_marks) > floatval($marks_detail->marks)){
                    //         $result != "" ? $result .= ',':'';
                    //         $result .=  $marks_detail['examdetail']->subject->uni_code;
                    //     }
                    // }
                    // else if($marks_detail['examdetail']->have_sub_papers == 'Y'){
                    //         $marks = 0;
                    //     if($marks_detail['sub_papers_marks'] && count($marks_detail['sub_papers_marks']) > 0){
                    //         foreach ($marks_detail['sub_papers_marks'] as $sub_paper) {
                    //             $marks .= floatval($sub_paper->marks);
                    //         }
                    //         if($marks < $marks_detail['examdetail']->min_marks){
                    //             $result != "" ? $result += ',':'';
                    //             $result .= ' ' +$marks_detail['examdetail']->subject->uni_code;
                    //         }
                    //     }
                    // }
                // }

                
            }

            if($result  == ""){
                $result = "PASS";
            }
            $std->result =  $result;
        }
        
        if($request->status != 'A'){
            $student =  [];
            foreach($students as $key=>$std){
                if($request->status == 'P'){
                    if($std->result == 'PASS'){
                        $student[]= $std;
                    }
                }
                else{
                    if($std->result != 'PASS'){
                        $student[]= $std;
                    }
                }
            }
            $students = $student;
        }
        // dd($request->all());
        if($request->mail_sent != 'A'){
            $student = [];
            foreach($students as $key=>$std){
                foreach ($std['marks_details'] as $marks_detail) {
                    if ($request->mail_sent == 'P') {
                        if ($marks_detail->mail_send == 'N') {
                            $student[]= $std;
                        }
                       
                    } else {
                        if ($marks_detail->mail_send == 'Y') {
                            $student[]= $std;
                        }
                        
                    }
                }
            }
            $studs = array_unique($student);
            $std = [];
            foreach($studs as $stu){
                $std[] = $stu;
            }

            $students = $std;
            
        }

        // dd($student);

        // dd($students);
        
        return reply('OK', [
            'students'=>$students,
            'details'=>$exam_detail
        ]);
    }

    public function getStudentCardPrint($id,$course_id,$exam,$sam)
    {
        $student = $this->getPrint($id,$course_id,$exam,$sam);
        $print = new \App\Printings\StudentCardPrint();
        $pdf = $print->makepdf($id,$this->exam_detail,$exam,$sam,$student);
        $pdf->Output("studentcard.pdf", 'I');
        exit();
       
    }

    public function getPrint($id,$course_id,$exam,$sam){
        // dd($exam);
        $examination = Exam::where('exam_name', $exam)->where('semester',$sam)->first();
        // dd($examination);
        $exam_id = $examination->id;
        $exam_detail = ExamDetails::where('exam_id',$exam_id)->where('course_id',$course_id)->get();
        $exam_detail->load('subject');
        $student = Student::
            join('marks', 'students.id', '=', 'marks.std_id')
            ->join('exam_details', 'exam_details.id', '=', 'marks.exam_det_id')
            ->join(getSharedDb() .'subjects', 'subjects.id', '=', 'exam_details.subject_id')
            ->where('exam_details.exam_id', '=', $exam_id)
            ->where('exam_details.course_id', '=', $course_id)
            ->where('students.id','=',$id)
            ->select('students.*','exam_details.min_marks','exam_details.max_marks','subjects.uni_code','marks.status','marks.id as marks_id','exam_details.have_sub_papers','exam_details.id as exam_det_id')
            ->with('marks_details.examdetail.subject','marks_details.subPapersMarks')
            ->get();
        return $student;
       
    }
    
    public function store(Request $request)
    {
        // dd($request->all());
       
        foreach($request->std_ids as $std_id ){
            // dd($request);
            $email = '';
            if($request->type == 'F'){
                $email = 'father_email';
            }
            else if($request->type == 'M'){
                $email = 'mother_email';
            }
            else if($request->type == 'G'){
                $email = 'guardian_email';
            }
            else{
                $std_email = Student::find($std_id)->load('std_user');
                $std_email = $std_email->std_user->email;
            }
            if($request->type != 'S'){
                $std_email = Student::where('id',$std_id)->pluck($email)->first();
            }
           
            $student = $this->getPrint($std_id,$request->course_id,$request->exam_name,$request->semester);
            $fileName = 'studentcard-' . $std_id . '.' . 'pdf';
            $print = new \App\Printings\StudentCardPrint();
            $pdf = $print->makepdf($std_id,$this->exam_detail,$request->exam_name,$request->semester,$student);
            $path = storage_path('app/print/'.get_fy_label() . '-' . $fileName);
            $pdf->Output($path, 'F');
            $email = $this->sendEmail($std_email, $request->subject,$request->msg, $path);
            $marks = StudentMarks::where('std_id','=',$std_id)->get();
            foreach($marks as $det){
                $det->mail_send = 'Y';
                $det->update();
            }
            
        }
        return response()->json([
            'success' => "Thank you! Your message has been sent successfully.",
        ], 200, ['app-status' => 'success']);
    }
    public function sendEmail($email, $subj,$msg,$path)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Mail::to($email)->send(new SendStudentResultEmail($subj,$msg,$path));
        } else {
            if (strlen(trim($email)) > 4) {
                return "$email not a valid E-mail Address";
            }
        }

    }
    
}
