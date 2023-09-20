<?php

namespace App\Http\Controllers\Online;

use Illuminate\Http\Request;
use App\Student;
use App\Models\StudentTimeTable\StudentTimeTable;

class TimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $login = auth('students');
        // dd(auth('students')->user());
        $student_timetable ='';
        $student = Student::where('std_user_id',auth('students')->user()->id)->first();
        if($student){
            $student->load('course');
            $student_timetable = StudentTimeTable::where('std_id',$student->id)->first();
        }
        if(file_exists(storage_path() . "/app/instructions/" .'timetable_'.$student->course_id .'.'. 'pdf') == true){
            $file = 'yes';
        }else{
            $file = 'no';
        }
        
        return view('online.student_timetable',compact('student_timetable','student','file'));
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
    public function show($id)
    {
        //
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

    public function showTimetableAttachment($course_id){
        $login = auth('students');
        $file_path = storage_path() . "/app/instructions/" .'timetable_'.$course_id .'.'. 'pdf';
        return response()->file($file_path);
    }
}
