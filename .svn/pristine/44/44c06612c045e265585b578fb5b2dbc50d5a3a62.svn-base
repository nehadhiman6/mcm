<?php

namespace App\Http\Controllers\Alumni;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendAlumniSms;
use App\Student;
use log;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendSms;
use App\Jobs\SendStudentsSms;
use App\Jobs\SendCourseStudentsSms;
use Gate;
use App\AlumniStudent;
use App\Course;

class SendSmsAlumniController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('alumni-sms-mail')) {
            return deny();
        }

        if (!request()->ajax()) {
            return view('alumni.sms.index');
        }
        $alumni_students = AlumniStudent::orderBy('name');
       

        if($request->type !="" || ($request->type !=""  && $request->student_course_id != 0)){
            $alumni_students->whereHas('almqualification',function($query) use($request){
                $query->where('degree_type',$request->type );
                if($request->student_course_id){
                    $query->where('course_id',$request->student_course_id );
                }
            });
        }

        else{
            if($request->course_id > 0){
                $alumni_students = $alumni_students->where('course_id',$request->course_id);
            }
            else if($request->course_type != ''){
                $courses = Course::where('status',$request->course_type)->pluck('id')->toArray();
                $alumni_students = $alumni_students->whereIn('course_id',$courses);
            }

            if($request->passout_year){
                $alumni_students = $alumni_students->where('passout_year',$request->passout_year);
            }
        }

       
        return response()->json([
            'alumni_students' => $alumni_students->get()
        ], 200, ['app-status' => 'success']);
    }

    public function getCoursesList(Request $request)
    {
        $course_type =  $request->course_type;
        $courses = Course::orderBy('sno');
        if($course_type == 'GRAD'){
            $courses = $courses->where(function ($q) {
                $q->where('status', '=', 'GRAD')
                ->where('course_year', '=', 3);
            });
           
        }
        if($course_type == 'PGRAD'){
            $courses = $courses->where(function ($q) {
                $q->where('status', '=', 'PGRAD')
                ->where('course_year', '=', 2)
                ->orWhere('course_name','=','PGDMC')
                ->orWhere('course_name','=','PGDCA');
            });
           
        }
        return response()->json([
            'courses' =>  $courses->get()
        ], 200, ['app-status' => 'success']);
        
    }

  
    public function store(Request $request)
    {
        dispatch(new SendAlumniSms($request->std_ids, $request->msg));
        return response()->json([
            'success' => "Thank you! Your message has been sent successfully.",
        ], 200, ['app-status' => 'success']);
    }

    // public function sendCourseSms(Request $request)
    // {
    //     dispatch(new SendCourseStudentsSms($request->course_id, $request->msg));
    //     return response()->json([
    //         'success' => "Thank you! Your message has been sent successfully.",
    //     ], 200, ['app-status' => 'success']);
    // }
}
