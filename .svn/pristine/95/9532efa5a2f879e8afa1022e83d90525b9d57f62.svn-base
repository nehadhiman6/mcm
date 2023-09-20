<?php

namespace App\Http\Controllers\StudentAdmissionForm;

use Illuminate\Support\Facades\DB;
use Session;
use App\AdmissionForm;
use App\AdmissionSubs;
use Illuminate\Http\Request;
use App\AdmissionHonourSubject;
use App\AdmissionSubPreference;
use App\AdmisssionSubCombination;
use App\ElectiveGroup;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Online\Controller;
use App\Http\Requests\StudentAdmissionRequests\SubjectOptionRequest as SubjectOptionRequest;
use App\Models\SubCombination\SubjectCombination;

class SubjectOptionController extends Controller
{
    protected $tab_no = 0;
    protected $admsubs = [];
    protected $course = null;
    protected $honour_subs = [];
    protected $adm_sub_prefs = [];



    private function getCurrentActiveTab()
    {
        $adm = AdmissionForm::whereStdUserId(auth('students')->user()->id)->first();
        return $adm ? $adm->active_tab : 0;
    }

    public function store(SubjectOptionRequest $request)
    {
        return $this->saveForm($request);
    }

    private function saveForm($request, $type = 'save')
    {
        $this->admsubs = [];
        $cmpgrps = $request->get("compGrp", []);
        $optgrps = $request->get("optionalGrp", []);
        $optsubs = $request->get("selected_opts", []);
        $elective_grps = $request->get('elective_grps', []);

        $grpsubs = [];
        $honours_subjects = $request->get("honoursSubjects", []);



        foreach ($cmpgrps as $value) {
            if ($value['selectedid'] != 0) {
                $grpsubs[$value['id']] = $value['selectedid'];
            }
        }

        $admprefs = AdmissionSubPreference::whereAdmissionId($request->form_id);
        if ($admprefs) {
            $admprefs->delete();
        } // i wrote it bcz data was not updating in folowing line kindly help

        foreach ($optsubs as $key => $value) {
            $admsub = new AdmissionSubs();
            $admsub->subject_id = $value;
            $admsub->sub_group_id = 0;
            $admsub->ele_group_id = 0;
            $admsub->preference_no = 1;
            $this->admsubs[] = $admsub;

            //for preferance 1 record
            $adm_sub_pref = new AdmissionSubPreference();
            $adm_sub_pref->subject_id = $value;
            $adm_sub_pref->sub_group_id = 0;
            $adm_sub_pref->ele_group_id = 0;
            $adm_sub_pref->selected_ele_id = $request->selected_ele_id;
            $adm_sub_pref->preference_no = 1;
            $this->adm_sub_prefs[] = $adm_sub_pref;
        }

        // select distinct a1.admission_id,a3.ele_id,a5.id as ele_group_id,a2.subject_id,a1.preference_no from
        // admission_sub_combination a1 join sub_combination_dets a2 on a1.sub_combination_id = a2.sub_combination_id
        // join sub_combination a3 on a2.sub_combination_id = a3.id
        // join course_subject a4 on a3.course_id = a4.course_id and a2.subject_id = a4.subject_id
        // left join (select distinct a1.id,a1.ele_id,a1.course_id,a2.course_sub_id from elective_group a1 join elective_group_det a2 on a1.id = a2.ele_group_id)a5
        // on a3.ele_id = a5.ele_id and a4.id = a5.course_sub_id
                

        foreach ($cmpgrps as $key => $value) {
            $admsub = new AdmissionSubs();
            $admsub->subject_id = $value['selectedid'];
            $admsub->sub_group_id = $value['id'];
            $admsub->ele_group_id = 0;
            $this->admsubs[] = $admsub;

            // $adm_sub_pref = new AdmissionSubPreference();
            // $adm_sub_pref->subject_id = $value['selectedid'];
            // $adm_sub_pref->sub_group_id = $value['id'];
            // $adm_sub_pref->selected_ele_id = $request->selected_ele_id;
            // $adm_sub_pref->ele_group_id = 0;
            // $this->adm_sub_prefs[] = $adm_sub_pref;
        }
        foreach ($optgrps as $value) {
            if ($value['selectedid'] != 0) {
                $admsub = new AdmissionSubs();
                $admsub->subject_id = $value['selectedid'];
                $admsub->sub_group_id = $value['id'];
                $admsub->preference_no = 1;
                $admsub->ele_group_id = 0;
                $this->admsubs[] = $admsub;
            }
        }

        foreach ($elective_grps as $value) {
            if (isset($value['selectedid']) && $value['selectedid'] != 0) {
                $admsub = new AdmissionSubs();
                $admsub->subject_id = $value['selectedid'];
                $admsub->sub_group_id = 0;
                $admsub->preference_no = 1;
                $admsub->ele_group_id = $value['id'];
                $this->admsubs[] = $admsub;

                //for preferance 1 record
                $adm_sub_pref = new AdmissionSubPreference();
                $adm_sub_pref->subject_id = $value['selectedid'];
                $adm_sub_pref->sub_group_id = 0;
                $adm_sub_pref->selected_ele_id = $request->selected_ele_id;
                $adm_sub_pref->preference_no = 1;
                $adm_sub_pref->ele_group_id = $value['id'];
                $this->adm_sub_prefs[] = $adm_sub_pref;
            }
        }

        foreach ($honours_subjects as $value) {
            if (intval($value['preference']) > 0) {
                $honour_sub = new AdmissionHonourSubject();
                $honour_sub->subject_id = $value['subject_id'];
                $honour_sub->preference = $value['preference'];
                $this->honour_subs[] = $honour_sub;
            }
        }

        if ($request->subject_preferences && count($request->subject_preferences) > 0) {
            foreach ($request->subject_preferences as $key => $pref) {
                foreach ($pref['selectedOpts'] as $option) {
                    if ($option['subject_id'] > 0) {
                        $adm_sub_pref = new AdmissionSubPreference();
                        $adm_sub_pref->subject_id = $option['subject_id'];
                        $adm_sub_pref->admission_id = $request->form_id;
                        $adm_sub_pref->selected_ele_id = $pref['selected_ele_id'];
                        $adm_sub_pref->ele_group_id = $option['ele_group_id'];
                        $adm_sub_pref->sub_group_id = 0;
                        $adm_sub_pref->preference_no = intval($key) + 2;
                        $this->adm_sub_prefs[] = $adm_sub_pref;
                    }
                }
            }
        }

        $sub_combinations = [];
        $sub_comb_ids = [];
        $comb_id_pref = [];
        if($request->course_id == 14) {
            foreach ($request->sub_combination as $value) {
                $combination = AdmisssionSubCombination::firstOrNew(['admission_id' => $value['admission_id'], 'id' => $value['id']]);
                $combination->admission_id = $value['admission_id'];
                $combination->preference_no = $value['preference_no'];
                $combination->sub_combination_id = $value['sub_combination_id'];
                $sub_combinations[] = $combination;
                $sub_comb_ids[] = $value['sub_combination_id'];
                $comb_id_pref[$value['preference_no']] = $value['sub_combination_id'];
            }
            $qry = ElectiveGroup::join('elective_group_det','elective_group.id','=','elective_group_det.ele_group_id')
                        ->select('elective_group.id','elective_group.ele_id','elective_group_det.course_sub_id');
            $qry = '('.$qry->toSql().')a1';
            
            $adm_data = SubjectCombination::join('sub_combination_dets','sub_combination_dets.sub_combination_id','=','sub_combination.id')
                        ->join('course_subject',function($join){
                            $join->on('sub_combination.course_id','=','course_subject.course_id')
                                    ->on('sub_combination_dets.subject_id','=','course_subject.subject_id');
                        })->leftJoin(DB::raw("$qry"),function($join){
                            $join->on('a1.ele_id','=','sub_combination.ele_id')
                                    ->on('a1.course_sub_id','=','course_subject.id');
                        })->whereIn('sub_combination.id',$sub_comb_ids)
                        ->select('sub_combination.id','sub_combination.ele_id','a1.id as ele_group_id','sub_combination_dets.subject_id');
            $adm_data = $adm_data->get();
            foreach($adm_data as $val) {
                $pref_no = ($t = array_keys($comb_id_pref,$val->id)) ? $t[0]:0;
                if($pref_no == 1) {
                    $admsub = new AdmissionSubs();
                    $admsub->subject_id = $val->subject_id;
                    $admsub->sub_group_id = 0;
                    $admsub->preference_no = $pref_no;
                    $admsub->ele_group_id = intval($val->ele_group_id);
                    $this->admsubs[] = $admsub;
                }
                $adm_sub_pref = new AdmissionSubPreference();
                $adm_sub_pref->subject_id = $val->subject_id;
                $adm_sub_pref->admission_id = $request->form_id;
                $adm_sub_pref->selected_ele_id = $val->ele_id;
                $adm_sub_pref->ele_group_id = intval($val->ele_group_id);
                $adm_sub_pref->sub_group_id = 0;
                $adm_sub_pref->preference_no = $pref_no;
                $this->adm_sub_prefs[] = $adm_sub_pref;
            }
            // logger($this->admsubs);
            // logger($this->adm_sub_prefs);
            // dd($this->admsubs);
        }
        $adm_form = AdmissionForm::findOrFail($request->form_id);

        $idarr = $adm_form->admSubs->pluck('id', 'id')->toArray();
        $idarr2 = $adm_form->honours->pluck('id', 'id')->toArray();
        $idarr3 = $adm_form->AdmissionSubPreference->pluck('id', 'id')->toArray();
        $admsubs = $this->admsubs;

        $adm_form->fill($request->all());
        if ($type == 'update') {
            $adm_form->active_tab = $this->getCurrentActiveTab();
        }
        foreach ($sub_combinations as $value) {
            $value->save();
        }
        // dd($this->adm_sub_prefs);
        DB::beginTransaction();


        AdmissionSubs::createOrUpdateMany($admsubs, ['admission_id' => $adm_form->id], $idarr);
        AdmissionHonourSubject::createOrUpdateMany($this->honour_subs, ['admission_id' => $adm_form->id], $idarr2);
        AdmissionSubPreference::createOrUpdateMany($this->adm_sub_prefs, ['admission_id' => $adm_form->id], $idarr3); //had problem with this adding my temp solution in line no
        $adm_form->update();

        DB::commit();

        return reply('ok', [
            'active_tab' => $this->getCurrentActiveTab(),
            'form_id' => $adm_form->id,
            'adm_form' => $adm_form->load('course', 'sub_combinations')
        ]);
    }



    public function update(SubjectOptionRequest $request, $id)
    {
        return $this->saveForm($request, 'update');
    }
}
