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

class ForMigAlumniRequest extends FormRequest
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

        $rules = [];
        if ($this->migrated == 'Y') {
            $rules['migrate_detail'] = "required";
        }
        if ($this->know_alumani == 'Y') {
            $rules['alumani.name'] = "required";
            $rules['alumani.passing_year'] = "required";
            $rules['alumani.occupation'] = "required";
            $rules['alumani.contact'] = "required";
        }
        if ($this->foreign_national == 'Y') {
            $rules['passport_validity'] = "required|date_format:d-m-Y";
            $rules['visa_validity'] = "required|date_format:d-m-Y";
            $rules['passportno'] = "required";
            $rules['visa'] = "required";
            $rules['res_permit'] = "required";
            $rules['res_validity'] = "required|date_format:d-m-Y";
        }
        return $rules;
    }

    public function messages()
    {
        return [];
    }
}
