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

class ParentDetailRequest extends FormRequest
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
        $this->id = $this->get('form_id');
        $adm_form = AdmissionForm::findOrFail($this->id);

        $rules = [
            // 'annual_income' => 'required|in:below 1 lac,1 to 2 lac,2 to 3 lac,3 to 4 lac,4 to 5 lac,above 5 lacs',
            'annual_income' => 'required|in:Upto 250000,250001-500000,500001-800000,800001-1000000,Above 1000001',
            'father_mobile' => 'required|min:10|digits:10',
            // 'father_email' => 'required|email|max:255',
            // 'mother_mobile' => 'required|min:10|digits:10',
            // 'mother_email' => 'required|email|max:255',
            // 'f_office_addr' => 'required',
        ];
        // if ($adm_form->hostel == 'Y') {
        //     $rules['guardian_mobile'] = "required|digits:10";
        //     $rules['guardian_address'] = "required";
        // }

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
        ];
        return $msgs;
    }
}
