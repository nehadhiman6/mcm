<?php

namespace App\Http\Controllers;

use App\AdmissionForm;
use App\AdmissionSubPreference;
use App\AdmissionSubs;
use Illuminate\Http\Request;
use App\AdmisssionSubCombination;
use App\ElectiveGroup;
use App\Models\SubCombination\SubjectCombination;
use Illuminate\Support\Facades\DB;

class AdmissionSubjectCombinationController extends Controller
{
    public function store(Request $request)
    {
        return $this->save($request);
    }

    public function save($request)
    {
        $sub_combinations = [];
        $sub_comb_ids = [];
        $comb_id_pref = [];
        $adm_subs = [];
        $adm_sub_prefs = [];
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
                    $adm_subs[] = $admsub;
                }
                $adm_sub_pref = new AdmissionSubPreference();
                $adm_sub_pref->subject_id = $val->subject_id;
                $adm_sub_pref->admission_id = $request->form_id;
                $adm_sub_pref->selected_ele_id = $val->ele_id;
                $adm_sub_pref->ele_group_id = intval($val->ele_group_id);
                $adm_sub_pref->sub_group_id = 0;
                $adm_sub_pref->preference_no = $pref_no;
                $adm_sub_prefs[] = $adm_sub_pref;
            }
        }
        $adm_form = AdmissionForm::findOrFail($request->form_id);
        $idarr = $adm_form->admSubs()->where('sub_group_id',0)->pluck('id', 'id')->toArray();
        $idarr3 = $adm_form->AdmissionSubPreference->pluck('id', 'id')->toArray();
        DB::beginTransaction();
        foreach ($sub_combinations as $value) {
            $value->save();
        }
        AdmissionSubs::createOrUpdateMany($adm_subs, ['admission_id' => $adm_form->id], $idarr);
        AdmissionSubPreference::createOrUpdateMany($adm_sub_prefs, ['admission_id' => $adm_form->id], $idarr3); //had problem with this adding my temp solution in line no
        $adm_form->update();

        DB::commit();

        return reply(true, [
            'form_id' => $adm_form->id,
            'adm_form' => $adm_form->load('course')
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
        $adm_form = \App\AdmissionForm::with(['course', 'admSubs', 'AdmissionSubPreference', 'admSubs.subjectGroup', 'admSubs.subject','sub_combinations'])->findOrFail($id);
        return view('admissionform.subject_combination', compact('adm_form'));
    }

    public function update(Request $request)
    {
        return $this->save($request);
    }


    
}
