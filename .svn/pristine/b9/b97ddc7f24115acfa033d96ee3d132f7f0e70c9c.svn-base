<?php

namespace App\Http\Controllers\Hostel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;

class HostelAllocationController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $students = \App\Student::join('fee_bills', 'fee_bills.std_id', '=', 'students.id')
                ->join('courses', 'courses.id', '=', 'students.course_id')->orderBy('courses.sno')
                ->where('fee_bills.fee_type', '=', 'Admission_Hostel')
                ->where('fee_bills.fund_type', '=', 'H')
                ->where('students.adm_cancelled', '=', 'N')
                ->where('students.hostel_room_id','=',0);
            if ($request->upto_date == '') {
                $students = $students->where('students.adm_date', getDateFormat($request->from_date, "ymd"));
            } else
                $students = $students->where('students.adm_date', '>=', getDateFormat($request->from_date, "ymd"))
                ->where('students.adm_date', '<=', getDateFormat($request->upto_date, "ymd"));
            if ($request->course_id != 0) {
                $students = $students->where('courses.id', '=', $request->course_id);
            }
            $students = $students->select('students.*', 'course_name');
            return $students->get();
        }       
        return view('hostels.allocation.index');
    }

    public function getHostelAllocated(Request $request)
    {
        if($request->ajax()){
            $students = \App\Student::join('fee_bills', 'fee_bills.std_id', '=', 'students.id')
            ->join('courses', 'courses.id', '=', 'students.course_id')->orderBy('courses.sno')
            ->where('fee_bills.fee_type', '=', 'Admission_Hostel')
            ->where('fee_bills.fund_type', '=', 'H')
            ->where('students.adm_cancelled', '=', 'N')
            ->where('students.hostel_room_id','!=',0);
            if ($request->upto_date == '') {
                $students = $students->where('students.adm_date', getDateFormat($request->from_date, "ymd"));
            } else
                $students = $students->where('students.adm_date', '>=', getDateFormat($request->from_date, "ymd"))
                ->where('students.adm_date', '<=', getDateFormat($request->upto_date, "ymd"));
            if ($request->course_id != 0) {
                $students = $students->where('courses.id', '=', $request->course_id);
            }
            if($request->location_id > 0){
                $students = $students->where('students.hostel_room_id','=',$request->location_id);
            }
            $students = $students->select('students.*', 'course_name')->with('hostel_location');
            return $students->get();
        }
        return view('hostels.allocation.allocated');
    }

    public function store(Request $request)
    {

        $this->validate($request,[
            'location_id'=>'required|exists:locations,id'
        ]);
        foreach($request->data as $student){
            if($student['checked'] == true){
                $student = Student::findOrFail($student['id']);
                $student->hostel_room_id = $request->location_id;
                $student->save();
            }
            else{
                $student = Student::findOrFail($student['id']);
                $student->hostel_room_id = 0;
                $student->save();
            }
       }
       return reply(true);
    }
   
    public function changeHostelAllocation(Request $request)
    {
        //
        $student = Student::findOrFail($request['student']['id']);
        $student->hostel_room_id = $request['student']['hostel_room_id'];
        $student->save();
        return reply(true,[
            'student' => $student
        ]);
    }
    
    public function edit($id)
    {
        //
    }
   
    public function update(Request $request, $id)
    {
        //
    }
   
    public function destroy($id)
    {
        //
    }
}
