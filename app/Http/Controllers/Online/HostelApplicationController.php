<?php

namespace App\Http\Controllers\Online;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gate;
use App\AdmissionFormHostel;

class HostelApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        if (auth('students')->check()) {
        }
        $adm_form = \App\AdmissionForm::findOrFail($id);
        if (Gate::denies('student-adm-form', $adm_form)) {
            abort('401', 'Resource does not belong to current user!!');
        }
        $adm_form = $adm_form->load('course');
        $admission_id = $adm_form->id;

        $hostel_form = $adm_form->hostel_form ?: new AdmissionFormHostel();
        return view('hostelform.create', compact('adm_form', 'admission_id', 'hostel_form'));
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
        $this->validate($request, [
            'admission_id' => 'required|integer',
            'schedule_backward_tribe' =>'required',
            'guardian_relationship' =>'required',
            'guardian_name' =>'required',
            'guardian_mobile' =>'required|digits:10|numeric',
            'guardian_address' =>'required',
            'room_mate' => 'nullable|string|max:200',
            'guardian_phone' =>'required|numeric',
        ]);
        $adm_form = \App\AdmissionForm::findOrFail($request->admission_id);
        $hostel_form = $adm_form->hostel_form ?: new AdmissionFormHostel();
        $hostel_form->fill($request->all());
        $hostel_form->save();
        return response()->json([
            'data'=> $hostel_form,
            'success'=>true
        ]);
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
        $this->validate($request, [
            'schedule_backward_tribe' =>'required',
            'guardian_relationship' =>'required',
            'guardian_name' =>'required',
            'guardian_mobile' =>'required',
            'guardian_address' =>'required',
            'guardian_phone' =>'required',
        ]);
        $hostel_form = \App\AdmissionFormHostel::findOrFail($id);
        $hostel_form->fill($request->all());
        $hostel_form->update();
        return response()->json([
            'data'=> $hostel_form,
            'success'=>true
        ]);
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
