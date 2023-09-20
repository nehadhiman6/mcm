<?php

namespace App\Http\Controllers\Hostel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Location;
use Carbon\Carbon;
use App\Models\Hostel\HostelAttendence;
use DB;

class HostelAttendenceController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $students = \App\Student::where('students.hostel_room_id','>',0);
            return $students->get();
        }
       
        return view('hostels.attendence.index');
    }

    public function getLocations(Request $request)
    {
        $locations = Location::where('block_id',$request->block_id)->get();
        return reply(true,[
            'locations' => $locations
        ]);
    }

    public function store(Request $request)
    {
        $this->validateForm($request);
        $attendance_date = Carbon::createFromFormat('d-m-Y', $request->attendance_date)->format('Y-m-d');
        $attendance = HostelAttendence::firstOrCreate([
            'attendance_date'=>$attendance_date,
            'course_id'=>$request->course_id,
            'roll_no'=>$request->roll_no,
        ], ['status'=>$request->status]);
        $attendance->status  = $request->status;
        $attendance->remarks  = $request->remarks;
        $attendance->update();   
        return reply(true,[
            'attendence' => $attendance
        ]);
    }

  
    public function validateForm($request)
    {
        $rules = [
            'attendance_date' =>'date|date_format:d-m-Y',
            'course_id'=>'required|exists:' . getYearlyDbConn() . '.courses,id',
        ];
        if ($request->has('students')) {
            $rules+=[
               'attendance_status'=>'required|in:P,A,N',
               'remarks'=>'nullable|max:500'
            ];
        }
        $this->validate($request, $rules, [
            'attendance_status.required'=>'Please select Attendence Status',
            'remarks.max'=>'remarks can not exceed 500 characters',
        ]);
    }
    public function getHostelAttendence(Request $request)
    {
        $attendance_date = Carbon::createFromFormat('d-m-Y', $request->attendance_date)->format('Y-m-d');
        $yesterday_attendance_date = Carbon::createFromFormat('d-m-Y',yesterday())->format('Y-m-d');
        $before_yesterday_attendance_date = Carbon::createFromFormat('d-m-Y',daybeforeyesterday())->format('Y-m-d');

        $students = \App\Student::leftJoin('hostel_attendence', function ($q) use ($attendance_date) {
                    $q->on('hostel_attendence.roll_no', '=', 'students.roll_no')
                    ->where('hostel_attendence.attendance_date','=',$attendance_date);
                })
                ->where('students.hostel_room_id','>',0);

        
        if($request->location_id != '0'){
            $students = $students->where('hostel_room_id',$request->location_id);
        }
        else if($request->block_id != '0' && $request->location_id == '0'){
            $locations = Location::where('block_id',$request->block_id)->pluck('id')->toArray();
            $students = $students->whereIn('hostel_room_id',$locations);
        }

        $students = $students->groupBy('students.id')->select('students.*','hostel_attendence.status','hostel_attendence.remarks');
        $students = $students->get();

        // for yesterday attendance status
        $yesterday_students = \App\Student::join('hostel_attendence', function ($q) use ($yesterday_attendance_date) {
            $q->on('hostel_attendence.roll_no', '=', 'students.roll_no')
            ->where('hostel_attendence.attendance_date','=',$yesterday_attendance_date);
        })
        ->where('students.hostel_room_id','>',0);
                    
        $yesterday_students= $yesterday_students->groupBy('students.id')->select('students.id','hostel_attendence.status');
        $yesterday_students = $yesterday_students->get();

        foreach($students as $stu){
            foreach($yesterday_students as $yes_stu){
                if($stu['id'] == $yes_stu['id']){
                    $stu['prev_status'] = $yes_stu['status'];
                }
            }
        }

        // for day before yesterday

        $day_before_yesterday = \App\Student::join('hostel_attendence', function ($q) use ($before_yesterday_attendance_date) {
            $q->on('hostel_attendence.roll_no', '=', 'students.roll_no')
            ->where('hostel_attendence.attendance_date','=',$before_yesterday_attendance_date);
        })
        ->where('students.hostel_room_id','>',0);
                    
        $day_before_yesterday= $day_before_yesterday->groupBy('students.id')->select('students.id','hostel_attendence.status');
        $day_before_yesterday = $day_before_yesterday->get();

        foreach($students as $stu){
            foreach($day_before_yesterday as $yes_stu){
                if($stu['id'] == $yes_stu['id']){
                    $stu['before_prev_status'] = $yes_stu['status'];
                }
            }
        }
        return $students;
    }

 
    public function getStudentDetails($roll_no)
    {
        $student_data = \App\Student::where('roll_no', $roll_no)->first();
        $student_data->load('hostel_location.block');
        if ($student_data && $student_data->hostel_room_id > 0) {
            return reply(true,
            [
                'student' => $student_data
            ]);
        }
        else{
            return reply(false);
        }
    }

    public function destroy($id)
    {
        //
    }
}
