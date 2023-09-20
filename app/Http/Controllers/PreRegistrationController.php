<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PreRegistration;

class PreRegistrationController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view('pre_registration.index');
        }
        $count = PreRegistration::all()->count();
        $filteredCount = $count;
        $registrations = PreRegistration::orderBy('id', 'DESC');
        if ($searchStr = $request->input('search.value')) {
            $registrations = $registrations->where('', 'like', "%{$searchStr}%");
        }
        
        $registrations = $registrations->take($request->length);
        $filteredCount = $registrations->count();

        $registrations = $registrations->select(['pre_registration.*'])->distinct()->get();
        $registrations->load('course','state');
        return [
            'draw' => intval($request->draw),
            'start'=>$request->start,
            'data' => $registrations,
            'recordsTotal' => $count,
            'recordsFiltered' => $filteredCount,
        ];
    }


    public function create()
    {
        return view('pre_registration.create');
    }

    public function store(Request $request)
    {
        return $this->saveForm($request);
    }

    private function saveForm(Request $request, $id=0)
    {
        $this->validateForm($request, $id);
        $pre_regi = PreRegistration::findOrNew($request->id);
        $pre_regi->fill($request->all());
        $pre_regi->save();
        return reply(true, compact('pre_regi'));
    }

    private function validateForm(Request $request, $id)
    {
        $rules = [
            'name'=> 'required|string|max:50',
            'father_name'=> 'required|string|max:50',
            'course_id'=> 'required|integer|exists:' . getYearlyDbConn() . '.courses,id',
            'mobile_no' => 'required|numeric',
            'add' => 'required|string|max:200',
            'email' => 'required|email|unique:' . getYearlyDbConn() . '.pre_registration,email,' . $request->id,
            'state_id' => 'required|integer|exists:states,id',
            'city' => 'required|string',
            'hostel' => 'required|in:Y,N'

        ];
        $messages = [
            
        ];
        // if($request->centre1 == $request->centre2){
        //     $rules['centre_re'] =  'required';
        //     $messages['centre_re.required'] = "This Centre already choose";
        // }

        $this->validate($request, $rules, $messages);
    }

    public function edit($id)
    {
        $pre_regi = PreRegistration::findOrFail($id);
        $pre_regi->load('course','state');
        return view('pre_registration.create', compact('pre_regi'));
    }

    public function update(Request $request, $id)
    {
        return $this->saveForm($request, $id);
    }

   
}
