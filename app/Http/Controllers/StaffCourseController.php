<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff\StaffCourse;
use App\Staff;

class StaffCourseController extends Controller
{
    public function index()
    {
        $courses = StaffCourse::orderBy('id', 'DESC')->get();
        if (!request()->ajax()) {
            return View('staff.staff_courses.index', compact(['courses']));
        }
        return $courses;
    }

    public function show(Request $request, $id){
        $staff_id = $id;
        $stf = $staff = Staff::where('id','=',$staff_id)->first();
        $stf->load('desig','dept');
        $staff = StaffCourse::where('staff_id','=', $staff_id)->orderBy('id', 'DESC')->get();
        return View('staff.staff_courses.create',compact('staff_id','staff','stf'));
    }

    public function store(Request $request, $id = 0)
    {
        $this->validateForm($request, $id);
        // dd($request->all());
        $staff = Staff::findOrFail($request->staff_id);
        $staff_course = StaffCourse::findOrNew($id);
        $staff_course->fill($request->course);
        $staff_course->save();
        return response()->json([
            'staff_course' => $staff_course, 
            'success' => "Course Add Successfully",
            'courses' => StaffCourse::where('staff_id','=', $staff->id)->orderBy('id', 'DESC')->get()
        ], 200, ['app-status' => 'success']);

        

    }
    private function validateForm(Request $request, $id)
    {
        // $this->validate(
        //     $request,
        //     [
        //         'staff_id'=>'required|exists:staff,id',
        //         'course_form.courses'=>'required',
        //         'course_form.topic'=>'required',
        //         'course_form.begin_date'=>'required|date_format:d-m-Y',
        //         'course_form.end_date'=>'required|date_format:d-m-Y',
        //         'course_form.university_id' =>'required'
                
        //     ]
        // );
            // dd($request->all());
        $rules = [
            // 'course_form.staff_id'=>'required|exists:staff,id',
            'course.courses'=>'required',
            'course.topic'=>'required',
            'course.begin_date'=>'required|date_format:d-m-Y',
            'course.end_date'=>'required|date_format:d-m-Y',
            'course.level' =>'required',
            // 'course.university_id' =>'required',
            'course.duration_days' =>'required',
            'course.org_by' =>'required',
            'course.sponsored_by' =>'required',
            'course.collaboration_with' =>'nullable',
            'course.aegis_of' =>'nullable',
            'course.participate_as' =>'required',
            'course.affi_inst' =>'required',
            'course.mode' =>'required',
            'course.certificate' =>'nullable',
            'course.remarks' =>'nullable',
        ];
        $messages = [
        ];
        // dd($request->course);
        if($request->course['university_id'] == 0 && $request->course['university_id'] != null){
            $rules['course.other_university'] =  'required';
            $messages['course.other_university.required'] = " Field is required";
        }

        if($request->course['courses'] == 'Any Other'){
            $rules['course.other_course'] =  'required';
            $messages['course.other_course.required'] = " Field is required";
        }

        if($request->course['sponsored_by'] == 'Any Other'){
            $rules['course.other_sponsor'] =  'required';
            $messages['course.other_sponsor.required'] = " Field is required";
        }

        $this->validate($request, $rules, $messages);
    }

    public function edit(Request $request, $id)
    {
        $course = StaffCourse::findOrFail($id);
        return reply('Ok', [
            'course' => $course,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request, $id);
        $staff = Staff::findOrFail($request->staff_id);
        $staff_course = StaffCourse::findOrFail($id);
        $staff_course->fill($request->course);
        $staff_course->update();
        return response()->json([
            'success' => "Staff Updated Successfully",
            'courses' => StaffCourse::where('staff_id','=', $staff->id)->orderBy('id', 'DESC')->get()
        ], 200, ['app-status' => 'success']);
    }
}
