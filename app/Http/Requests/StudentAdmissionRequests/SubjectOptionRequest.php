<?php

namespace App\Http\Requests\StudentAdmissionRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Log;
use App\AcademicDetail;
use App\AdmissionSubs;
use App\AdmissionHonourSubject;
use App\AdmissionForm;
use App\AdmissionSubPreference;
use App\Course;

class SubjectOptionRequest extends FormRequest
{
    protected $course = null;
    protected $admsubs = [];
    protected $honour_subs = [];
    protected $adm_sub_prefs = [];
    protected $id = 0;
    protected $form_id = 0;
    protected $optsubsqty = 0;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $this->id = $this->form_id;

        $rules = [
            'medium' => 'required|in:Hindi,English,Punjabi',
            'punjabi_in_tenth' => 'required_if:course_type,GRAD',

        ];

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
        $this->admsubs = [];
        $cmpgrps = $this->get("compGrp", []);
        $optgrps = $this->get("optionalGrp", []);
        $optsubs = $this->get("selected_opts", []);
        $elective_grps = $this->get('elective_grps', []);
        $this->optsubsqty = count($optsubs);
        $grpsubs = [];

        foreach ($cmpgrps as $value) {
            if ($value['selectedid'] != 0) {
                $grpsubs[$value['id']] = $value['selectedid'];
            }
        }

        foreach ($elective_grps as $value) {
            if (isset($value['selectedid']) && $value['selectedid'] != 0) {
                $this->optsubsqty++;
            }
        }


        if (intval($this->course_id) > 0) {
            $this->course = \App\Course::find($this->course_id);
            if ($this->course && $this->course_id != 14) {
                if ($this->optsubsqty < $this->course->min_optional || $this->optsubsqty > $this->course->max_optional) {
                    $rules['opt_subs_count'] = "required";
                }
                $compSubs = $this->course->getSubGroups('C');
                foreach ($compSubs as $value) {
                    if (array_key_exists($value['id'], $grpsubs) == false) {
                        $rules['comp_group'] = "required";
                    }
                }

                if ($this->course->course_id == "BA" && $this->course->course_year == 1 && count($this->subject_preferences) < 5) {
                    $rules['preferences_count'] = "required";
                }
            }
        }

        

        return $rules;
    }

    public function messages()
    {
        $msgs = [
            'guardian_name.required' => 'Guardian\'s Name is required if you are applying for hostel.',
            'guardian_mobile.required' => 'Enter Guardian\'s mobile number.',
            'guardian_address.required' => 'Enter Guardian\'s address.',
            'guardian_relationship.required' => 'Please Specify relationship with Guardian.',
            'f_office_addr.required' => 'Father\'s office addess is Mandatory.',
            'comp_group.required' => 'Select a group.',
            'preferences_count.required' => 'Fill 6 subject preferences at least.',
        ];
        if (intval($this->course_id) > 0) {
            // if ($this->optsubsqty != 3) {
            //     $msgs['opt_subs_count.required'] = 'Check! Select exactly 3 elective subjects for Preference no. 1 ';
            // }
            if ($this->optsubsqty < $this->course->min_optional) {
                $msgs['opt_subs_count.required'] = 'Check ! Preference 1 Minimum Optional subject should not be less than ' . $this->course->min_optional;
            } elseif ($this->optsubsqty > $this->course->max_optional) {
                $msgs['opt_subs_count.required'] = 'Check ! Preference 1 Maximum Optional subject should not be more than ' . $this->course->max_optional;
            }
        }
        return $msgs;
    }
}
