<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\SubjectOptionRequest;
use App\AdmissionForm;
use App\AdmissionHonourSubject;
use App\AdmissionSubPreference;
use App\AdmissionSubs;
use Illuminate\Support\Facades\DB;

class AddmissionFormSubjectOptionController extends Controller
{
    protected $tab_no = 0;
    protected $admsubs = [];
    protected $course = null;
    protected $honour_subs = [];
    protected $adm_sub_prefs = [];
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save($request)
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

        foreach ($cmpgrps as $key => $value) {
            $admsub = new AdmissionSubs();
            $admsub->subject_id = $value['selectedid'];
            $admsub->sub_group_id = $value['id'];
            $admsub->ele_group_id = 0;
            $this->admsubs[] = $admsub;
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



        $adm_form = AdmissionForm::findOrFail($request->form_id);

        $adm_form->selected_ele_id = $request->selected_ele_id;
        $adm_form->punjabi_in_tenth = $request->punjabi_in_tenth;

        $idarr = $adm_form->admSubs->pluck('id', 'id')->toArray();
        $idarr2 = $adm_form->honours->pluck('id', 'id')->toArray();
        $idarr3 = $adm_form->AdmissionSubPreference->pluck('id', 'id')->toArray();
        $admsubs = $this->admsubs;


        // dd($this->adm_sub_prefs);
        DB::beginTransaction();

        AdmissionSubs::createOrUpdateMany($admsubs, ['admission_id' => $adm_form->id], $idarr);
        AdmissionHonourSubject::createOrUpdateMany($this->honour_subs, ['admission_id' => $adm_form->id], $idarr2);
        AdmissionSubPreference::createOrUpdateMany($this->adm_sub_prefs, ['admission_id' => $adm_form->id], $idarr3); //had problem with this adding my temp solution in line no
        $adm_form->update();

        DB::commit();

        return reply(true, [
            'form_id' => $adm_form->id,
            'adm_form' => $adm_form->load('course')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectOptionRequest $request)
    {
        return $this->save($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('EDIT-ADMISSION-FORMS')) {
            return deny();
        }

        $adm_form = \App\AdmissionForm::with(['course', 'admSubs', 'AdmissionSubPreference', 'admSubs.subjectGroup', 'admSubs.subject'])->findOrFail($id);
        $old_hon_sub = [];
        if ($adm_form->lastyr_rollno) {
            $student_data = \App\PrvStudent::where('roll_no', $adm_form->lastyr_rollno)->first();
            if ($student_data) {
                $old_hon_sub = $student_data->getOldHonSub();
            }
        }
        $course = $adm_form->course;
        $course_type = $course->status;
        $compSubs = $adm_form->course->getSubs('C');
        $optionalSubs = $adm_form->course->getSubs('O');
        $compGrps = $adm_form->course->getSubGroups('C');
        $optionalGrps = $adm_form->course->getSubGroups('O');
        $electives = $adm_form->course->getElectives();
        $alumani =  $adm_form->alumani;
        $hostel_data =  $adm_form->hostelData;
        $becholor_degree_details = $adm_form->becholorDegreeDetails;
        $selectedOpts = [];
        foreach ($adm_form->admSubs as $value) {
            if ($value->sub_group_id > 0 && $value->subjectGroup) {
                if ($value->subjectGroup->type == "C") {
                    foreach ($compGrps as $key => $val) {
                        if ($val['id'] == $value->sub_group_id) {
                            $compGrps[$key]['selectedid'] = $value->subject_id;
                        }
                    }
                } elseif ($value->ele_group_id > 0) {
                    foreach ($optionalGrps as $key => $val) {
                        if ($val['id'] == $value->sub_group_id) {
                            $optionalGrps[$key]['selectedid'] = $value->subject_id;
                        }
                    }
                }
            } else {
                if ($value->ele_group_id > 0 && $value->electiveGroup) {
                    foreach ($electives as $ele) {
                        if ($ele->id == $adm_form->selected_ele_id) {
                            foreach ($ele->groups as $grp) {
                                foreach ($grp->details as $detail) {
                                    if ($detail->subject_id == $value->subject_id) {
                                        $grp->selectedid = $value->subject_id;
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $selectedOpts[] = $value->subject_id;
                }
            }
        }
        $honoursSubjects = $course->getHonours();
        $preferences = $adm_form->honours->pluck('preference', 'subject_id');
        // dd($preferences);
        foreach ($honoursSubjects as $honSub) {
            $honSub['opted'] = isset($preferences[$honSub->subject_id]) ? true : false;
            $honSub['selected'] = false;
            $honSub['preference'] = isset($preferences[$honSub->subject_id]) ? $preferences[$honSub->subject_id] : 0;
        }
        // dd($honoursSubjects);
        // dd($adm_form);
        $data = compact('adm_form', 'compSubs', 'optionalSubs', 'compGrps', 'optionalGrps', 'electives', 'selectedOpts', 'honoursSubjects', 'course_type', 'alumani', 'hostel_data', 'becholor_degree_details', 'old_hon_sub');
        return view('admissionform.subject_option', $data);
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
