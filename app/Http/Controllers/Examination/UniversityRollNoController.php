<?php

namespace App\Http\Controllers\Examination;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UniversityRollNoController extends Controller
{
    public function index(Request $request)
    {
        // if (Gate::denies('date-sheet-list')) {
        //     return deny();
        // }
        if($request->ajax()){
            
            $students = \App\Student::where('course_id',$request->course_id)->get();
            $course_status = \App\Course::find($request->course_id);
            $status = $course_status->status;
            return reply(true, [
                'data' => $students,
                'status' => $status,
            ]);
        }
        return view('examinations.uni_roll_no');
    }

    public function store(Request $request)
    {
        
        $field_name = $request->field_name;
        $stu_detail = \App\Student::findOrFail($request->id);
        $stu_detail->$field_name = $request->value;
        $stu_detail->save();
        return reply('OK',[
            'stu_detail' => $stu_detail
        ]);
    }
}
