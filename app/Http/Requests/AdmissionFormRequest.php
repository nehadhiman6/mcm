<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Log;
use App\AcademicDetail;
use App\AdmissionSubs;
use App\AdmissionHonourSubject;
use App\AdmissionForm;
use App\Course;

class AdmissionFormRequest extends FormRequest
{
    protected $course = null;
    protected $admsubs = [];
    protected $honour_subs = [];
    protected $id = 0;
    protected $form_id = 0;
    protected $optsubsqty = 0;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->id = $this->route('admission_form');
        $this->course = Course::findOrFail($this->course_id);
        // dd($this->course);
        //    dd($this->id);
        $rules = [
            'loc_cat' => 'required_if:course_code,BCAI,BCAII,BCAIII,BBAI,BBAII,BBAIII,BCOMI,BCOMII,BCOMIII,BSCI,BSCII,BSCIII,B.COM-I SF,B.COM-II SF,B.COM-III SF,MCOMI,MCOMII,MCOMIII,MSC-I CHEM,MSC-II CHEM,MSC-MATH,MSC-II MATH',
            'cat_id' => 'required|exists:categories,id',

            'course_id' => 'required|exists:' . getYearlyDbConn() . '.courses,id',
            'resvcat_id' => 'required|exists:res_categories,id',
            'conveyance' => 'required',
            'geo_cat' => 'required',
            'nationality' => 'required',
            'name' => 'required',
            'mobile' => 'required|min:10|max:10',
            'minority' => 'required|min:1',
            'annual_income' => 'required',
            'punjabi_in_tenth' => 'required_if:course_type,GRAD',
            // 'aadhar_no' => 'required|min:12|max:12',
            'gender' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'blood_grp' => 'required',
            'dob' => 'required|date_format:d-m-Y',
            'per_address' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'father_mobile' => 'required|min:10|digits:10',
            'father_email' => 'nullable|email|max:255',
            'mother_mobile' => 'nullable|min:10|digits:10',
            'mother_email' => 'nullable|email|max:255',
            'terms_conditions' => 'required|in:"Y"',
            'acades.*.result' => 'required|in:PASS,FAIL,COMPARTMENT,RESULT AWAITED,RL',
            'acades.*.institute' => 'required',
            'acades.*.board_id' => 'required',
            'acades.*.rollno' => 'required',
            'acades.*.year' => 'required',
            'acades.*.total_marks' => 'required_if:acades.*.result,PASS',
            'acades.*.division' => 'required_if:acades.*.result,PASS',
            'acades.*.reappear_subjects' => 'required_if:acades.*.result,COMPARTMENT',
            'acades.*.marks_obtained' => 'required_if:acades.*.result,PASS',
            'acades.*.marks_per' => 'required_if:acades.*.result,PASS',
            'acades.*.subjects' => 'required',
            'acades.*.other_exam' => 'required_if:acades.*.exam,Others',
            'acades.*.other_board' => 'required_if:acades.*.board_id,0',
            'acades.*.inst_state_id' => 'required',
            'f_office_addr' => 'nullable',
            'medium' => 'required|in:Hindi,English,Punjabi'
        ];
        if ($this->nationality == 'INDIAN') {
            $rules['state_id'] = 'required|exists:states,id';
        }
        foreach ($this->acades as $key => $detail) {
            // if (data_get($detail, 'id', 0) > 0) {
            //     $rules["acades.$key.exam"] = 'required|unique:' . getYearlyDbConn() . '.academic_detail,exam,' . $detail['id'] . ',id,admission_id,' . $this->id;
            // } else {
            //     $rules["acades.$key.exam"] = 'required|unique:' . getYearlyDbConn() . '.academic_detail,exam,null,id,admission_id,' . $this->id;
            // }
            if ($detail['marks_per'] > 0 && $detail['total_marks'] > 0 && $detail['marks_obtained'] > 0) {
                $marksper = (floatval($detail['marks_obtained']) * 100) / floatval($detail['total_marks']);
                if($detail['cgpa'] == 'Y'){
                    $rules["acades.$key.marks_per"] = "numeric";
                }
                else{
                    $rules["acades.$key.marks_per"] = "numeric|min:" . floor($marksper) . "|max:" . ceil($marksper);
                }
            }
            if ($detail['result'] != 'COMPARTMENT') {
                $detail['reappear_subjects'] = '';
            }
        }
        // nullable fields add blank value

        if ($this->epic_no == '' || !$this->epic_no) {
            $this->epic_no = " ";
        }
        if ($this->aadhar_no == '' || !$this->aadhar_no) {
            $this->aadhar_no = " ";
        }


        if ($this->migrated == 'Y') {
            $rules['migrate_detail'] = "required";
        }
        if ($this->minority == 'Y') {
            $rules['religion'] = "required";
        }
        if ($this->religion == "Others") {
            $rules['other_religion'] = "required";
        }
        if ($this->epic_card == "Y") {
            $rules['epic_no'] = "required|min:10";
        }
        if ($this->adhar_card == "Y") {
            $rules['aadhar_no'] = "required";
        }
        if ($this->differently_abled == "Y") {
            $rules['remarks_diff_abled'] = "required";
        }
        if ($this->know_alumani == 'Y') {
            $rules['alumani.name'] = "required";
            $rules['alumani.passing_year'] = "required";
            $rules['alumani.occupation'] = "required";
            $rules['alumani.contact'] = "required";
        }
        if ($this->disqualified == 'Y') {
            $rules['disqualify_detail'] = "required";
        }
        if ($this->last_exam_mcm == 'Y' && $this->course->course_year > 1) {
            $rules['lastyr_rollno'] = "required";
        }

        if ($this->course->course_year == 2 || $this->course->course_year == 3) {
            $rules['boarder'] = "required";
        }

        if ($this->foreign_national == 'Y') {
            $rules['nationality'] = "required";
            $rules['passport_validity'] = "required|date_format:d-m-Y";
            $rules['visa_validity'] = "required|date_format:d-m-Y";
            $rules['passportno'] = "required";
            $rules['visa'] = "required";
            $rules['res_permit'] = "required";
            $rules['res_validity'] = "required|date_format:d-m-Y";
        }
        if ($this->sports == 'Y' || $this->academic == 'Y' || $this->cultural == 'Y') {
            $rules['spl_achieve'] = "required";
        }
        if ($this->hostel == 'Y') {
            $rules['guardian_name'] = "nullable";
            $rules['guardian_mobile'] = "nullable|digits:10";
            $rules['guardian_address'] = "nullable";
            $rules['guardian_relationship'] = "nullable";
            $rules['schedule_backward_tribe'] = "required";
        }

        if ($this->course_type == 'PGRAD') {
            $rules['postgraduate.bechelor_degree'] = "required";
            $rules['postgraduate.subjects'] = "required";
            $rules['postgraduate.percentage'] = "required";
            $rules['postgraduate.marks_obtained'] = "required";
            $rules['postgraduate.total_marks'] = "required";
            if ($this->postgraduate['percentage'] > 0 && $this->postgraduate['total_marks'] > 0 && $this->postgraduate['marks_obtained'] > 0) {
                $marksper = (floatval($this->postgraduate['marks_obtained']) * 100) / floatval($this->postgraduate['total_marks']);
                $rules["postgraduate.percentage"] = "numeric|min:" . floor($marksper) . "|max:" . ceil($marksper);
            }

            $rules['postgraduate.elective_subject'] = "required";
            $rules['postgraduate.ele_obtained_marks'] = "required";
            $rules['postgraduate.ele_total_marks'] = "required";
            $rules['postgraduate.ele_percentage'] = "required";
            if ($this->postgraduate['ele_percentage'] > 0 && $this->postgraduate['ele_total_marks'] > 0 && $this->postgraduate['ele_obtained_marks'] > 0) {
                $marksper = (floatval($this->postgraduate['ele_obtained_marks']) * 100) / floatval($this->postgraduate['ele_total_marks']);
                $rules["postgraduate.ele_percentage"] = "numeric|min:" . floor($marksper) . "|max:" . ceil($marksper);
            }

            if ($this->postgraduate['honour_percentage'] > 0 && $this->postgraduate['honour_total_marks'] > 0 && $this->postgraduate['honour_marks'] > 0) {
                $marksper = (floatval($this->postgraduate['honour_marks']) * 100) / floatval($this->postgraduate['honour_total_marks']);
                $rules["postgraduate.honour_percentage"] = "numeric|min:" . floor($marksper) . "|max:" . ceil($marksper);
            }

            if ($this->lastyr_rollno != '') {
                $rules['postgraduate.pg_sem1_subject'] = "required";
                $rules['postgraduate.pg_sem1_obtained_marks'] = "required";
                $rules['postgraduate.pg_sem1_total_marks'] = "required";
                $rules['postgraduate.pg_sem1_percentage'] = "required";

                if ($this->postgraduate['pg_sem1_percentage'] > 0 && $this->postgraduate['pg_sem1_total_marks'] > 0 && $this->postgraduate['pg_sem1_obtained_marks'] > 0) {
                    $marksper = (floatval($this->postgraduate['pg_sem1_obtained_marks']) * 100) / floatval($this->postgraduate['pg_sem1_total_marks']);
                    $rules["postgraduate.pg_sem1_percentage"] = "numeric|min:" . floor($marksper) . "|max:" . ceil($marksper);
                }
                $rules['postgraduate.pg_sem2_subject'] = "required";
                if ($this->postgraduate['pg_sem2_result'] == "PASS") {
                    $rules['postgraduate.pg_sem2_obtained_marks'] = "required";
                    $rules['postgraduate.pg_sem2_total_marks'] = "required";
                    $rules['postgraduate.pg_sem2_percentage'] = "required";
                }

                if ($this->postgraduate['pg_sem2_percentage'] > 0 && $this->postgraduate['pg_sem2_total_marks'] > 0 && $this->postgraduate['pg_sem2_obtained_marks'] > 0) {
                    $marksper = (floatval($this->postgraduate['pg_sem2_obtained_marks']) * 100) / floatval($this->postgraduate['pg_sem2_total_marks']);
                    $rules["postgraduate.pg_sem2_percentage"] = "numeric|min:" . floor($marksper) . "|max:" . ceil($marksper);
                }
            }
        }
        //validation
        $honours_subjects = $this->get("honoursSubjects", []);
        $h = [];
        foreach ($honours_subjects as $value) {
            if (intval($value['preference']) > 1) {
                $h[] = 'preference.' . (intval($value['preference']) - 1);
            }
        }
        foreach ($honours_subjects as $value) {
            if (intval($value['preference']) > 0) {
                if (($key = array_search('preference.' . $value['preference'], $h)) !== false) {
                    unset($h[$key]);
                }
            }
        }
        foreach ($h as $r) {
            $rules[$r] = 'required';
        }

        //dd('here');
        //    if(($this->acades['marks_per'][0])!= null){
        //     $rules ["acades.$key.marks_per"]= "in:intval(acades.$key.marks_obtained * 100)/intval(acades.$key.total_marks);
        //    }


        $this->admsubs = [];
        $cmpgrps = $this->get("compGrp", []);
        $optgrps = $this->get("optionalGrp", []);
        $optsubs = $this->get("selectedOpts", []);
        $elective_grps = $this->get('elective_grps', []);
        $this->optsubsqty = count($optsubs);
        $grpsubs = [];

        foreach ($optgrps as $value) {
            if ($value['selectedid'] != 0) {
                $this->optsubsqty++;
            }
        }
        foreach ($elective_grps as $value) {
            if (isset($value['selectedid']) && $value['selectedid'] != 0) {
                $this->optsubsqty++;
            }
        }
        foreach ($cmpgrps as $value) {
            if ($value['selectedid'] != 0) {
                $grpsubs[$value['id']] = $value['selectedid'];
            }
        }
        if (intval($this->course_id) > 0) {
            $this->course = \App\Course::find($this->course_id);
            if ($this->course) {
                if ($this->optsubsqty < $this->course->min_optional || $this->optsubsqty > $this->course->max_optional) {
                    $rules['opt_subs_count'] = "required";
                }
                $compSubs = $this->course->getSubGroups('C');
                foreach ($compSubs as $value) {
                    if (array_key_exists($value['id'], $grpsubs) == false) {
                        $rules['comp_group'] = "required";
                    }
                }
                if ($this->course->course_year > 1) {
                    $rules['pupin_no'] = "required";
                    $rules['pu_regno'] = "required";
                }
            }
        }

        foreach ($optsubs as $key => $value) {
            $admsub = new AdmissionSubs();
            $admsub->subject_id = $value;
            $admsub->sub_group_id = 0;
            $admsub->ele_group_id = 0;
            $this->admsubs[] = $admsub;
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
                $admsub->ele_group_id = 0;
                $this->admsubs[] = $admsub;
            }
        }
        foreach ($elective_grps as $value) {
            if (isset($value['selectedid']) && $value['selectedid'] != 0) {
                $admsub = new AdmissionSubs();
                $admsub->subject_id = $value['selectedid'];
                $admsub->sub_group_id = 0;
                $admsub->ele_group_id = $value['id'];
                $this->admsubs[] = $admsub;
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

        //    dd($rules);
        return $rules;
    }

    public function messages()
    {
        $msgs = [
            'loc_cat.required' => 'Select one of the Relevant Category',
            'geo_cat.required' => 'Select one of the for information field',
            'resvcat_id.required' => 'Reserved Category field is required',
            'name.required' => 'Please Mention Your Full Name',
            'aadhar_no.required' => 'AAdhar No. Field is Mandatory',
            'lastyr_rollno.required' => 'Please Enter your roll no of this college.',
            'lastyr_rollno.unique' => 'This Roll no has already been Taken.',
            'epic_no.required' => 'EPIC No. Field is Mandatory',
            'cat_id.required' => 'Select one of the Category',
            'dob.required' => 'Please fill your Date Of Birth',
            'other_religion.required' => 'Please mention other religion',
            'remarks_diff_abled.required' => 'Please mention different ability',
            'spl_achieve.required' => 'Please write about special Achievement',
            'per_address.required' => 'Please Fill permanent address field',
            'comp_group.required' => 'Check ! In each Compulsory Group One subject should be selected',
            'acades.*.exam.required' => 'Exam Field Can not be left Blank',
            'acades.*.result.required' => 'Result Field Can not be left Blank',
            'acades.*.exam.unique' => 'This Exam Has Already been Filled Try Another.',
            'acades.*.other_exam.required_if' => 'If Others Exam Selected. Please Mention Your ExamName.',
            'acades.*.institute.required' => 'Institute Field Can not be left Blank',
            'acades.*.inst_state_id.required' => 'Please mention Institution State',
            'acades.*.board_id.required' => 'Board Field Can not be left Blank',
            'acades.*.other_board.required_if' => 'If Others Board Selected. Please Mention Your Board',
            'acades.*.rollno.required' => 'Roll No Field Can not be left Blank',
            'acades.*.year.required' => 'Year Field Can not be left Blank',
            'acades.*.total_marks.required' => 'Total Marks Field Can not be left Blank',
            'acades.*.marks_obtained.required' => 'Marks Obtained Field Can not be left Blank',
            'acades.*.marks_per.required' => '%age Field Can not be left Blank',
            'acades.*.marks_per.min' => 'Check Your Marks %age.',
            'acades.*.marks_per.max' => 'Check Your Marks %age',
            'acades.*.subjects.required' => 'Subjects Field Can not be left Blank',
            'f_nationality.required' => 'If You Are A Foreign National Please Fill Your nationality',
            'terms_conditions.in' => 'You Have To Agree With the Terms And Conditions in Declaration.',
            'guardian_name.required' => 'Guardian\'s Name is required if you are applying for hostel.',
            'guardian_mobile.required' => 'Enter Guardian\'s mobile number.',
            'guardian_address.required' => 'Enter Guardian\'s address.',
            'guardian_relationship.required' => 'Please Specify relationship with Guardian.',
            'conveyance.required' => 'Please mention conveyance',
            'medium.required' => 'Please mention Medium.',
            'f_office_addr.required' => 'Father\'s office addess is Mandatory.',
            'pu_regno.required' => 'Enter PU Roll Number.',
            'pupin_no.required' => 'Enter PU Reg No./PUPIN No.',
            'blood_grp.required' => 'Enter your blood group.',
            'postgraduate.bechelor_degree.required' => ' Enter Graduation degree',
            'postgraduate.subjects.required' => ' Enter Graduation  Subjects',
            'postgraduate.percentage.required' => ' Enter Graduation  Percentage',
            'postgraduate.percentage.min' => 'Check Your Marks %age.',
            'postgraduate.marks_obtained.required' => ' Enter Graduation  obtained marks',
            'postgraduate.total_marks.required' => ' Enter Graduation  Total Marks',
            'postgraduate.elective_subject.required' => ' Enter Elective  Subject.',
            'postgraduate.ele_obtained_marks.required' => 'Enter Elective  Subject marks obtained',
            'postgraduate.ele_percentage.required' => 'Enter Elective  Subject Percentage.',
            'postgraduate.ele_percentage.min' => 'Check Your Marks %age.',
            'postgraduate.ele_total_marks.required' => 'Enter Elective  Subject total marks.',
            'postgraduate.pg_sem1_subject.required' => 'Enter semester I  Subjects',
            'postgraduate.pg_sem1_obtained_marks.required' => 'Enter semester I obtained marks.',
            'postgraduate.pg_sem1_total_marks.required' => 'Enter semester I total marks',
            'postgraduate.pg_sem1_percentage.required' => 'Enter semester I Percentage.',
            'postgraduate.pg_sem1_percentage.min' => 'Check Your Marks %age.',
            'postgraduate.pg_sem2_subject.required' => 'Enter semester II  Subjects',
            'postgraduate.pg_sem2_total_marks.required' => 'Enter semester II total marks',
            'postgraduate.pg_sem2_obtained_marks.required' => 'Enter semester II total marks',
            'postgraduate.pg_sem2_percentage.required' => 'Enter semester II Percentage.',
            'postgraduate.pg_sem2_percentage.min' => 'Check Your Marks %age.',
            'postgraduate.honour_percentage.min' => 'Check Your Marks %age.',
        ];
        if (intval($this->course_id) > 0) {
            if ($this->optsubsqty < $this->course->min_optional) {
                $msgs['opt_subs_count.required'] = 'Check ! Minimum Optional subject should not be less than ' . $this->course->min_optional;
            } elseif ($this->optsubsqty > $this->course->max_optional) {
                $msgs['opt_subs_count.required'] = 'Check ! Maximum Optional subject should not be more than ' . $this->course->max_optional;
            }
        }
        return $msgs;
    }

    public function getAdmForm()
    {
        $adm_form = null;
        if ($this->app_guard == 'students' && auth('students')->check()) {
            $adm_form = AdmissionForm::where('std_user_id', auth('students')->user()->id)->first();
        } elseif ($this->app_guard == 'web' && auth('web')->check()) {
            $adm_form = AdmissionForm::find($this->id);
        }
        if ($adm_form == null) {
            $adm_form = new AdmissionForm();
        }
        return $adm_form;
    }

    public function save()
    {
        $adm_form = $this->getAdmForm();
        // Log::info($adm_form);
        $adm_form->fill($this->all());
        if ($adm_form->loc_cat == null) {
            $adm_form->loc_cat = " ";
        }
        $adm_form->punjabi_in_tenth = is_null($this->get('punjabi_in_tenth', 'N')) ? 'N' : $this->get('punjabi_in_tenth', 'N');

        //dd($student);
        // $adm_form->annual_income = 0;
        if ($adm_form->exists == false && $this->app_guard == 'students' && auth('students')->check()) {
            $adm_form->std_user_id = auth('students')->user()->id;
        }

        $idarr = $adm_form->admSubs->pluck('id', 'id')->toArray();
        $idarr1 = $adm_form->academics->pluck('id', 'id')->toArray();
        $idarr2 = $adm_form->honours->pluck('id', 'id')->toArray();
        $admsubs = $this->admsubs;
        //    dd($admsubs);
        //    $admsubs = $this->getAdmSubs();
        DB::beginTransaction();
        $adm_form->save();
        if ($this->know_alumani == 'Y') {
            $this->alumani = \App\Alumani::firstOrNew(['admission_id' =>  $adm_form->id]);
            $this->alumani->fill($this->get("alumani"));
            $this->alumani->save();
        }
        if ($this->hostel == 'Y') {
            $this->hostel_data = \App\AdmissionFormHostel::firstOrNew(['admission_id' =>  $adm_form->id]);
            $this->hostel_data->fill($this->get("hostel_data"));
            $this->hostel_data->save();
        }
        if ($this->course_type == 'PGRAD') {
            $this->becholor_degree_details = \App\BechelorDegreeDetails::firstOrNew(['admission_id' =>  $adm_form->id]);
            $this->becholor_degree_details->fill($this->get("postgraduate"));
            $this->becholor_degree_details->save();
        }
        AcademicDetail::createOrUpdateMany($this->acades, ['admission_id' => $adm_form->id], $idarr1);
        AdmissionSubs::createOrUpdateMany($admsubs, ['admission_id' => $adm_form->id], $idarr);
        AdmissionHonourSubject::createOrUpdateMany($this->honour_subs, ['admission_id' => $adm_form->id], $idarr2);

        DB::commit();
        $this->form_id = $adm_form->id;
    }

    private function getAdmSubs()
    {
        $admsubs = [];
        foreach ($this->selectedOpts as $value) {
            $admsubs[] = ['subject_id' => $value];
        }
        foreach ($this->grps as $key => $value) {
            foreach ($value as $key1 => $val) {
                $admsubs[] = ['sub_group_id' => $key1, 'subject_id' => $this->cmp_grp[$key1]];
            }
        }
        return $admsubs;
    }

    public function admissionSubs()
    {
        return $this->admsubs;
    }

    public function redirect()
    {
        if ($this->ajax()) {
            if ($this->id) {
                return reply("Student Updated Successfully", ['form_id' => $this->form_id]);
            } else {
                return reply("To complete Registration attach documents required. Click ADD ATTACHMENTS", ['form_id' => $this->form_id]);
            }
        }
    }
}
