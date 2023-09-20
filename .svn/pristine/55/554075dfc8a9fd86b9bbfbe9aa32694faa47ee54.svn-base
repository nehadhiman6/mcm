<?php

namespace App\Http\Controllers\Admissions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdmEntryRequest;
use App\Jobs\SendSms;
use App\Mail\Notification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ConsentController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('CONSENTS')) {
            return deny();
        }
        if (!request()->ajax()) {
            return view('admentries.consent.index');
        } else {
            $consents = \App\AddmissionConsent::orderBy('id', 'desc')
                ->with([
                    'admission_form' => function ($q) {
                        $q->select('id', 'std_user_id', 'name', 'father_name', 'mobile', 'status', 'course_id', 'lastyr_rollno');
                    },
                    'admission_form.course' => function ($q) {
                        $q->select('id', 'course_name');
                    },
                    'admission_form.std_user' => function ($q) {
                        $q->select('id', 'email');
                    },
                    'honour_assigned.subject',
                    'subject_selected_preferences.subject',
                    'user'

                ]);
                
            $consents = $consents->where('adm_consent.created_at', '>=', mysqlDate($request->from_date));
            if ($request->upto_date == '') {
                $consents = $consents->where('adm_consent.created_at', '<=', mysqlDate($request->upto_date));
            }
         
            if ($request->input('status', '') != 'A') {
                $consents = $consents->where('ask_student', $request->status);
            }
            if ($request->input('student_answer', '') != 'A') {
                $consents = $consents->where('student_answer', $request->student_answer);
            }

            if (intval($request->input('course_id')) > 0) {
                $consents = $consents->join('admission_forms', 'admission_forms.id', '=', 'adm_consent.admission_id');
                if (intval($request->input('course_id')) > 0) {
                    $consents = $consents->where('admission_forms.course_id', '=', $request->course_id);
                }
            }

            if ($request->entry_status != '') {
                $consents = $consents->leftJoin('admission_entries', 'admission_entries.admission_id', '=', 'adm_consent.admission_id');
                if ($request->entry_status == 'A') {
                    $consents = $consents->whereNotNull('admission_entries.id');
                }
                if ($request->entry_status == 'N') {
                    $consents = $consents->whereNull('admission_entries.id');
                }
            }
            
            return $consents->select('adm_consent.*')->get();
        }
    }

    /**
     * Check Manual Form No Duplication
     *
     */
  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (Gate::denies('NEW-CONSENT-ENTRY')) {
            return deny();
        }

        if (!request()->ajax()) {
            return view('admentries.consent.create');
        }

        $adm_form = \App\AdmissionForm::findOrFail($request['admission_id']);
        $adm_form->load(['std_user','course','AdmissionSubPreference.subjectGroup','AdmissionSubPreference.electiveGroup',
                            'AdmissionSubPreference.subject','honours.subject','admSubs.subject']);

        $consent = \App\AddmissionConsent::where('admission_id', $request->admission_id)->first();
        return reply(true, [
                'adm_form'=>$adm_form,
                'consent'=>$consent
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('NEW-CONSENT-ENTRY')) {
            return deny();
        }
        $this->validate($request, [
            'admission_id'=>'required|not_in:0',
            'preference_no'=>'required|not_in:0',
        ]);
        
        $consent = \App\AddmissionConsent::firstOrNew(['admission_id'=>$request->admission_id]);
        $consent->fill($request->all());
        $consent->user_id = auth()->user()->id;

        $admission_sub_preference = \App\AdmissionSubPreference::where('admission_id', $request->admission_id)->where('preference_no', $request->preference_no)->get();

        if ($request->preference_no != 1) {
            $admission_subs = \App\AdmissionSubs::where('admission_id', $request->admission_id)->where('sub_group_id', '=', 0)->get();
            $subs_ids = $admission_subs->pluck('id')->toArray();
            $used_ids = [];
            $selected_ele_id = 0;
        }
        DB::connection(getYearlyDbConn())->beginTransaction();

        if ($request->preference_no != 1) {
            foreach ($admission_sub_preference as $key=>$sub_preference) {
                $selected_ele_id= $sub_preference['selected_ele_id'];
                $admission_subs[$key]['sub_group_id'] = $sub_preference['sub_group_id'];
                $admission_subs[$key]['preference_no'] = $sub_preference['preference_no'];
                $admission_subs[$key]['ele_group_id'] = $sub_preference['ele_group_id'];
                $admission_subs[$key]['subject_id'] = $sub_preference['subject_id'];
                $admission_subs[$key]->save();
                array_push($used_ids, $admission_subs[$key]['id']);
            }
        }

        if ($request->ask_student == 'N') {
            $consent->student_answer = 'Y';
        } else {
            $consent->student_answer = 'R';
        }

        $consent->save();
        $admission_form = \App\AdmissionForm::findOrFail($request->admission_id);
        if ($request->preference_no != 1) {
            $admission_form->selected_ele_id = $selected_ele_id;
            $admission_form->save();
            $detach_adms = array_diff($subs_ids, $used_ids);
            \App\AdmissionSubs::whereIn('id', $detach_adms)->where('sub_group_id', '=', 0)->delete();
        }
        DB::connection(getYearlyDbConn())->commit();

        if ($consent->ask_student == 'Y') {
            // $msg = "Dear student, we have alotted your subjects/honours according to your preference. You can check the same and give your consent by login into MCM Students Portal on https://admissions.mcmdav.com/stulogin with in 24 hours for further processing.";
            // $msg = "Dear student, we have alotted you subject/course you applied for. You can check the same and give your consent by login into MCM Students Portal on https://admissions.mcmdav.com/stulogin with in 24 hours for further processing.";
            $msg = "Dear student, we have allotted you subject/course you applied for. Your Online Form No is {$admission_form->id}. You can check the same and give your consent by logging into Students' Portal on https://admissions.mcmdav.com/stulogin with in 24 hours for further processing -MCMDAVCW";
            $template_id = '1207162850636704022';
            dispatch(new SendSms($msg, $admission_form->mobile,$template_id));
            Mail::to($admission_form->std_user)->queue(new Notification($msg));
        }

        return reply(true, [
            'consent'=>$consent
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('NEW-CONSENT-ENTRY')) {
            return deny();
        }
        $adm_entry = \App\AdmissionEntry::findOrFail($id);
        //  dd('here');
        return view('admentries.create', compact('adm_entry') + ['form_task' => 'edit']);

        $student_det = $adm_entry->admForm;
        $student_det->load(['std_user']);
        $std_type = $adm_entry->stdType;
        //  dd($std_type);
        $course = $student_det->course;
        if ($student_det->course) {
            $compSubs = $student_det->course->getSubs('C');
            $optionalSubs = $student_det->course->getSubs('O');
            $compGrps = $student_det->course->getSubGroups('C');
            $optionalGrps = $student_det->course->getSubGroups('O');
            $selectedOpts = [];
            foreach ($student_det->admSubs as $value) {
                if ($value->sub_group_id == 0) {
                    $selectedOpts[] = $value->subject_id;
                } else {
                    if ($value->subjectGroup->type == "C") {
                        foreach ($compGrps as $key => $val) {
                            if ($val['id'] == $value->sub_group_id) {
                                $compGrps[$key]['selectedid'] = $value->subject_id;
                            }
                        }
                    } else {
                        foreach ($optionalGrps as $key => $val) {
                            if ($val['id'] == $value->sub_group_id) {
                                $optionalGrps[$key]['selectedid'] = $value->subject_id;
                            }
                        }
                    }
                    //            $grps[$value->subjectGroup->type][$value->sub_group_id] = '';
                }
            }
        }
        return view('admentries.create', compact('student_det', 'std_type', 'adm_entry', 'compSubs', 'optionalSubs', 'compGrps', 'optionalGrps', 'selectedOpts', 'course') + ['form_task' => 'edit']);
    }
}
