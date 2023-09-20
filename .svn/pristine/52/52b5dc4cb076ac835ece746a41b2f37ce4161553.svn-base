<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exam;
use App\ExamDetails;
use App\Mail\SendMail;
use App\Student;
use Illuminate\Support\Facades\Mail;
use Gate;

class SendMailStudentController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('send-stu-email')) {
            return deny();
        }
        if(!$request->ajax())
        {
            return view('messages.send_stu_email.index');
        }

        $this->validate($request,[
            'course_id'=>'required|integer|min:1',
        ],
        [
            'course_id.min'=>'The Course Field is required',
        ]);

        $students = \App\Student::existing()->notRemoved()
            ->join('courses', 'courses.id', '=', 'students.course_id')->orderBy('courses.sno');
        if ($request->course_id != 0) {
            $students = $students->where('courses.id', '=', $request->course_id);
        }
        $students = $students->select('students.*', 'course_name')->get()->load('std_user');
        return reply('OK', [
            'students'=>$students,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
       
        foreach($request->std_ids as $std_id ){
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
          
            $email = $this->sendEmail($std_email, $request->subject,$request->msg);
            
        }
        return response()->json([
            'success' => "Thank you! Your message has been sent successfully.",
        ], 200, ['app-status' => 'success']);
    }
    public function sendEmail($email, $subj,$msg)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Mail::to($email)->send(new SendMail($subj,$msg));
        } else {
            if (strlen(trim($email)) > 4) {
                return "$email not a valid E-mail Address";
            }
        }

    }


}
