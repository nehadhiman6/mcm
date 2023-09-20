<?php

namespace App\Http\Controllers;

use App\Staff;
use Illuminate\Http\Request;
use App\Models\Staff\TemporaryStaff;
use DB;
use Gate;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('staff-list')){
            return deny();
        }
        $staffs = Staff::orderBy('name')->with(['user.image','qualifications','desig','courses','first_designation.old_desig','promotions.new_desig','faculty'])->get();
        if (!request()->ajax()) {
            return View('staff.staff.index', compact('staffs'));
        }
        return $staffs;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('staff-modify')){
            return deny();
        }
        return view('staff.staff.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Gate::denies('staff-modify')){
            return deny();
        }
        // return $request->all();
        $this->doValidate($request);
        $staff = new Staff();
        $staff->fill($request->all());
        $staff->save();
        return response()->json([
            'success' => "staff Saved Successfully",
            'first'=>true,
            'staff' => $staff
        ], 200, ['app-status' => 'success']);
    }

    public function doValidate(Request $request, $id = 0)
    {
        $rules = [
            'name' => 'required|string|max:50',
            'dob'=> 'required|date_format:d-m-Y',
            'subject_id' => 'integer',
            'gender' => 'required',
            'email' => 'sometimes|nullable|email|max:255',
            'desig_id' => 'required',
            'dept_id' => 'required',
            'address' => 'max:70',
            'mobile' => 'required|numeric|min:10',
            'source' => 'required',
            'type' => 'required',
            'salutation' => 'required',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'faculty_id' => 'nullable|integer|exists:faculty,id',
            'address_res' => 'required|string|max:200',
            'area_of_specialization' => 'required|in:M.Phill,PHD,Other',
            // 'other_specialization' => 'required_if:area_of_specialization,Other|max:100',
         
            'teaching_exp' => 'nullable|string',
        ];

        if($id == 0){
            $rules += [
                'mcm_joining_date' => 'required|date_format:"d-m-Y"'
            ];
        }
        $is_teacher = false;
        if (auth()->user()->hasRole('TEACHERS')) {
            $is_teacher = true;
        }
        if($is_teacher){
            $rules+=[
                'disclaimer'=>'required|in:Y'
            ];
            if(!auth()->user()->image){
                $rules+=[
                    'image'=>'required'
                ];
            }
        }

        $this->validate($request,$rules,
        [
            'disclaimer.required'=>'Please tick above checkbox.',
            'disclaimer.in'=>'Please tick above checkbox.',
            'image.required'=>'Image is mandatory. Please upload image. '
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        if(Gate::denies('staff-modify')){
            return deny();
        }
        $is_teacher = false;
        if (auth()->user()->hasRole('TEACHERS')) {
            $is_teacher = true;
        }
        $staff = \App\Staff::findOrFail($id);
        $staff->load('user.image','experiences','qualifications','researches');

        $staff->area_of_specialization = 'Other';
        if($is_teacher ==  true && $staff->disclaimer == 'N'){
            $staff->name = '';
            $staff->middle_name = '';
            $staff->last_name = '';
            
        }
        return view('staff.staff.create', compact('staff', 'is_teacher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Gate::denies('staff-modify')){
            return deny();
        }
        $this->doValidate($request, $id);
        $staff = Staff::findOrFail($id);
        $staff->fill($request->all());
        $staff->update();
        return response()->json([
            'success' => "staff updated Successfully",
            'staff'=>$staff
        ], 200, ['app-status' => 'success']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function staffLeft($staff_id)
    {
        $staff = Staff::findOrFail($staff_id);
        return view('staff.staff.left',compact('staff_id','staff'));
    }

    public function saveStaffLeft(Request $request){
        $this->validate($request,[
            'staff_id' => 'required|exists:staff,id',
            'mcm_joining_date'=>'required',
            'left_date'=>'required|date_format:d-m-Y|after_or_equal:mcm_joining_date',
            'left_status'=>'required|not_in:0',
            'remarks'=>'nullable|max:500'
        ]);


        $temporary_staff = TemporaryStaff::where('staff_id',$request->staff_id)->where('mcm_joining_date',getDateFormat($request->mcm_joining_date, "ymd"))->first();
        if(!$temporary_staff){
            $temporary_staff = new TemporaryStaff();
        }

        DB::beginTransaction();
            $temporary_staff->fill($request->all());
            $temporary_staff->save();

            $staff = Staff::findOrFail($request->staff_id);
            $staff->left_date = $request->left_date;
            $staff->save();
        DB::commit();

    }

    public function staffRejoin($staff_id){
        $staff = Staff::findOrFail($staff_id);
        return view('staff.staff.join',compact('staff_id','staff'));
    }

    public function saveStaffRejoin(Request $request){
        $this->validate($request,[
            'staff_id' => 'required|exists:staff,id',
            'left_date'=>'required',
            'mcm_joining_date'=>'required|date_format:d-m-Y|after_or_equal:left_date',
            'remarks'=>'nullable|max:500'
        ]);

        $temporary_staff = new TemporaryStaff();

        DB::beginTransaction();
            $temporary_staff->fill($request->all());
            $temporary_staff->left_date = null;
            $temporary_staff->save();
            $staff = Staff::findOrFail($request->staff_id);
            $staff->left_date = "";
            $staff->mcm_joining_date = $request->mcm_joining_date;
            $staff->save();
        DB::commit();
    }
}
