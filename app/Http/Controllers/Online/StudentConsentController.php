<?php

namespace App\Http\Controllers\Online;

use Illuminate\Http\Request;

class StudentConsentController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()){
            $adm = \App\AdmissionForm::whereStdUserId(auth('students')->user()->id)->first();
            $adm->load(['consent.honour_assigned.subject','admSubs.subject','AdmissionSubPreference.subject','honours.subject']);
            return view('admissionformnew._consent',compact('adm'));
        }
    }

    public function store(Request $request){
        $rules = [];
        if($request->upgrade_later == 'N' ){
            $rules = [
                'student_answer'=>'required|in:Y,N'
            ];
        }

        $this->validate($request,$rules);
        $consent = \App\AddmissionConsent::where('admission_id',$request->admission_id)->first();
        $consent->fill($request->all());
        $consent->save();
        return reply(true,[
            'consent'=>$consent
        ]);
    }
   
}
