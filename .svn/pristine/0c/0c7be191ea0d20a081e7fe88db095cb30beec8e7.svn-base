<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use App\AdmissionSubs;
use App\Jobs\SendSms;
use App\Mail\Notification;
use App\StudentUser;
use Illuminate\Support\Facades\Mail;

class AdmEntryRequest extends FormRequest
{
    protected $course = null;
    protected $admsubs = [];
    protected $id = 0;
    protected $response = [];
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
        //dd($this->all());
        $this->id = $this->route('adm_entry');
        //    dd($this->id);
        // dd($this->has('adm_entry.admission_id'));
        $rules = [
            'adm_entry.admission_id' => (($this->has('adm_entry.manual_formno') && intval($this->input('adm_entry.manual_formno')) > 0) ? '' : 'required|numeric|min:1|') . (intval($this->input('adm_entry.admission_id')) > 0 ? 'exists:' . getYearlyDbConn() . '.admission_forms,id' : ''),
            'adm_entry.manual_formno' => ($this->has('adm_entry.admission_id') ? '' : 'required_without:adm_entry.admission_id|') . (intval($this->input('adm_entry.admission_id')) > 0 ? '' : 'required|') . 'numeric|nullable',
            'adm_entry.std_type_id' => 'required|numeric|min:1',
            'adm_entry.id' => 'sometimes|unique:' . getYearlyDbConn() . '.students,adm_entry_id,null,id,adm_cancelled,N',
            'student_det.course_id' => 'required|exists:' . getYearlyDbConn() . '.courses,id',
            'student_det.name' => 'required',
            'student_det.mobile' => 'required|min:10|max:10',
            'student_det.father_name' => 'required',
            'student_det.loc_cat' => 'required_unless:student_det.course_id,14,student_det.course_id,13,student_det.course_id,1',
            'student_det.geo_cat' => 'required',
            'student_det.cat_id' => 'required',
            'student_det.resvcat_id' => 'required',
            'student_det.nationality' => 'required',
            // 'student_det.religion' => 'required',
            'student_det.gender' => 'required',
            'student_det.course_id' => 'required|integer|min:1',
            // 'student_det.lastyr_rollno' =>'required_if:adm_entry.std_type_id,2',
            'student_det.lastyr_rollno' => 'required',
            'std_user.email' => 'required|unique:' . getYearlyDbConn() . '.student_users,email,' . $this->input('std_user.id', 0)
        ];
        //    dd($rules);
        //    if ($this->std_user_id == 0)
        //      $rules['std_user.email'] = 'required|unique:' . getYearlyDbConn() . '.student_users';
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
        if ($this->exists('student_det.course_id') && intval($this->student_det['course_id']) != 0) {
            $this->course = \App\Course::find($this->student_det['course_id']);
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
            }
        }
        //    foreach ($optsubs as $key => $value) {
        //      $stdsub = new \App\StudentSubs();
        //      $stdsub->subject_id = $value;
        //      $stdsub->sub_group_id = 0;
        //      $this->stdsubs[] = $stdsub;
        //    }
        foreach ($optsubs as $key => $value) {
            $admsub = new \App\AdmissionSubs();
            $admsub->subject_id = $value;
            $admsub->sub_group_id = 0;
            $this->admsubs[] = $admsub;
        }
        foreach ($cmpgrps as $key => $value) {
            $admsub = new \App\AdmissionSubs();
            $admsub->subject_id = $value['selectedid'];
            $admsub->sub_group_id = $value['id'];
            $this->admsubs[] = $admsub;
        }
        foreach ($optgrps as $value) {
            if ($value['selectedid'] != 0) {
                $admsub = new \App\AdmissionSubs();
                $admsub->subject_id = $value['selectedid'];
                $admsub->sub_group_id = $value['id'];
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
        return $rules;
    }

    public function messages()
    {
        $msgs = [
            'adm_entry.std_type_id.min' => 'Student Type is Required',
            'adm_entry.id.unique' => 'Student has been admitted already!!',
            'student_det.course_id.required' => 'Select one of the Relevant Course You Want to Study',
            'student_det.name.required' => "Please Mention Student's Full Name",
            'student_det.father_name.required' => "Please Fill Student's Father Name",
            'student_det.mobile.required' => 'Mobile no. Should not be empty ',
            'student_det.loc_cat.required' => 'Select one of the Relevant Category',
            'student_det.geo_cat.required' => 'Select one of the for information field',
            'student_det.resvcat_id.required' => 'Reserved Category field is required',
            'student_det.cat_id.required' => 'Select one of the Category',
            // 'student_det.religion.required' => 'Please Mention Your Religion ',
            'student_det.nationality.required' => 'Please Fill Your natinality',
            'student_det.gender.required' => 'Gender Field is required ',
            'std_user.email.required' => 'Email Should not be empty ',
            'std_user.email.unique' => 'Email has Already be taken ',
            'student_det.comp_group.required' => 'Check ! In each Compulsory Group One subject should be selected',
        ];
        if ($this->exists('student_det.course_id') && intval($this->student_det['course_id']) != 0) {
            if ($this->optsubsqty < $this->course->min_optional) {
                $msgs['opt_subs_count.required'] = 'Check ! Minimum Optional subject should not be less than ' . $this->course->min_optional;
            } else {
                $msgs['opt_subs_count.required'] = 'Check ! Maximum Optional subject should not be more than ' . $this->course->min_optional;
            }
        }
        return $msgs;
    }

    public function save()
    {

        //    dd($this->id);
        $adm_entry = intval($this->input('adm_entry.id', 0)) > 0 ? \App\AdmissionEntry::findOrFail($this->input('adm_entry.id')) : new \App\AdmissionEntry();
        $adm_form = intval($this->input('adm_entry.admission_id', 0)) > 0 ? \App\AdmissionForm::findOrFail($this->input('adm_entry.admission_id')) : new \App\AdmissionForm();
        //    $adm_form = $adm_entry->admForm ?: new \App\AdmissionForm();
        //    $student_user = $this->exists('std_user.id') ? \App\StudentUser::findOrFail($this->input('std_user.id')) : new \App\StudentUser();
        $student_user = $adm_form->std_user ?: new \App\StudentUser();
        //    dd($adm_form->std_user);
        //    if ($this->id == 0) {
        //      $student_user = new \App\StudentUser();
        //      $adm_form = new \App\AdmissionForm();
        //    } else {
        //      $adm_entry = \App\AdmissionEntry::find($this->id);
        //      $adm_form = \App\AdmissionForm::find($adm_entry->admission_id);
        //    }
        $adm_entry->fill(array_only($this->input('adm_entry'), ['admission_id', 'std_type_id', 'dhe_form_no', 'manual_formno', 'centralized', 'adm_rec_no', 'rcpt_date', 'amount', 'addon_course_id', 'honour_sub_id']));
        $adm_entry->valid_till = tomorrow();
        // $adm_entry->valid_till = today();
        if (!$student_user->exists) {
            $pass = str_random(6);
            $student_user->fill(['email' => $this->input('std_user.email'), 'mobile' => $this->input('student_det.mobile'), 'password' => bcrypt($pass)]);
            $student_user->initial_password = $pass;
        } else {
            $student_user->fill(['email' => $this->input('std_user.email'), 'mobile' => $this->input('student_det.mobile')]);
        }
        $adm_form->fill(array_only($this->student_det, [
            'name', 'father_name', 'mobile', 'course_id', 'loc_cat',
            'geo_cat', 'cat_id', 'resvcat_id', 'nationality', 'religion', 'gender', 'conveyance', 'veh_no', 'lastyr_rollno', 'selected_ele_id'
        ]));
        //    var_dump($adm_entry);
        //    var_dump($student_user);
        //    var_dump($adm_form);
        //    dd($this->id);
        if ($this->input('adm_entry.centralized') == 'Y') {
            $student = $adm_form->student;
            if (!$student && $this->form_task == 'create') {
                //        dd('here');
                $student = new \App\Student();
            } else {
                $student = $adm_form->student ?: new \App\Student();
            }
            $student->fill($adm_form->attributesToArray());
            $stdsubs = [];
            foreach ($this->admsubs as $sub) {
                $stdsubs[] = $sub->toArray();
            }
            //      dd($student);
        }
        DB::beginTransaction();
        DB::connection(getYearlyDbConn())->beginTransaction();
        $adm_entry->save();
        $adm_form->adm_entry_id = $adm_entry->id;
        //    if ($this->id == 0) {
        $student_user->save();
        $adm_form->std_user_id = $student_user->id;
        if (intval($adm_form->active_tab) == 0) {
            $adm_form->active_tab = 1;
        }
        $adm_form->save();
        $adm_entry->admission_id = $adm_form->id;
        $adm_entry->save();

        $idarr = $adm_form->admSubs->pluck('id', 'id')->toArray();
        $admsubs = $this->admsubs;
        \App\AdmissionSubs::createOrUpdateMany($admsubs, ['admission_id' => $adm_form->id], $idarr);

        if ($adm_entry->centralized == 'Y') {
            $student->admission_id = $adm_form->id;
            $student->adm_entry_id = $adm_entry->id;
            $student->std_type_id = $adm_entry->std_type_id;
            $student->std_user_id = $adm_form->std_user_id;
            $student->adm_date = today();
            $student->save();
            DB::connection(getYearlyDbConn())->table('student_subs')->where('student_id', '=', $student->id)->delete();
            $student->stdsubs()->createMany($stdsubs);

            $adm_form->status = 'A';
            $adm_form->std_id = $student->id;
            $adm_form->update();
        }
        DB::connection(getYearlyDbConn())->commit();
        DB::commit();

        $this->response = [
            'adm_entry_id' => $adm_entry->id,
            'std_user_id' => $student_user->id,
            'totalFee' => $adm_form->getAdmFeeTotal()
        ];

        $std_user = StudentUser::find($student_user->id);
        // $msg = "Candidate (Form No: {$adm_form->id}), you can pay the admission fees online till 12:00 midnight " . today() . " by going to url https://admissions.mcmdav.com/payadmfees/create ";
        // $msg = "Dear Applicant, kindly pay your MCM DAV CW admission fee online till 12:00 noon " . $adm_entry->valid_till . " by opening the url https://admissions.mcmdav.com/payadmfees/create ";
        // $msg = "Dear Applicant , pay your admission fee online till 4:00 pm today by going to url https://admissions.mcmdav.com/payadmfees/create";
        
        if (strlen(trim($std_user->initial_password)) > 0) {
            // $msg .= " Login Credentials - Email: {$std_user->email}, Password: {$std_user->initial_password}";
            // https://admissions.mcmdav.com/payadmfees/create
            $msg = "Dear Applicant, kindly pay your MCM DAV CW admission fee online till 12:00 noon " . $adm_entry->valid_till . " by opening the url https://admissions.mcmdav.com/payadmfees/create ";
            $msg .= "using Login Credentials -Email : {$std_user->email}, Password: {$std_user->initial_password}";
            $msg .= ", Online Form No: {$adm_form->id})";
            // $template_id = '1207166201704647356';
            $template_id = '1207162825310260945';
        } else {
            $msg = "Dear Applicant, kindly pay your admission fee online till 12:00 noon " . $adm_entry->valid_till . " by opening the url https://admissions.mcmdav.com/payadmfees/create, ";
            $msg .= "Online Form No: {$adm_form->id})- MCMDAVCW";
            $template_id = '1207162825300321650';
        }

        // $msg = "Dear Applicant, kindly pay your admission fee online till 12:00 noon" . $adm_entry->valid_till . " by opening the url https://admissions.mcmdav.com/payadmfees/create, ";
        // $msg .= "Online Form No: {$adm_form->id})- MCMDAVCW"
        // $template_id = '1207162825300321650';
        if (env('APP_ENV', 'production') == 'production') {
            dispatch(new SendSms($msg, $student_user->mobile, $template_id));
        }
        // Mail::to($std_user)->queue(new Notification(str_replace("00:00 noon","mid night",$msg)));
        Mail::to($std_user)->queue(new Notification($msg));
    }

    public function redirect()
    {
        if ($this->ajax()) {
            $this->response['success'] = "Admission Entry Successfull";
            return response()
                ->json($this->response, 200, ['app-status' => 'success']);
        }
    }
}
