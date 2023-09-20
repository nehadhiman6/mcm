<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    protected $id = 0;
    protected $student_id = 0;

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
        $this->id = $this->route('student');
        //  dd($this->id);
        $rules = [
          'student.name' => 'required',
          'student.mobile' => 'required|min:10|max:10',
          'student.father_name' => 'required',
          'student.mother_name' => 'required',
          'student.blood_grp' => 'required',
          'student.loc_cat' => 'required',
          'student.geo_cat' => 'required',
          'student.cat_id' => 'required',
          'student.resvcat_id' => 'required',
          'student.nationality' => 'required',
          'student.gender' => 'required',
          'student.per_address' => 'required',
          'student.pincode' => 'required',
          'student.aadhar_no' => 'required|min:12|max:12',
        ];
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

        return $rules;
    }

    public function messages()
    {
        $msgs = [
          'student.name.required' => "Please Mention Student's Full Name",
          'student.father_name.required' => "Please Fill Student's Father Name",
          'student.mother_name.required' => "Please Fill Student's Mother Name",
          'student.blood_grp.required' => "Please Mention your Blood Group",
          'student.mobile.required' => 'Mobile no. Should not be empty ',
          'student.loc_cat.required' => 'Select one of the Relevant Category',
          'student.geo_cat.required' => 'Select one of the for information field',
          'student.resvcat_id.required' => 'Reserved Category field is required',
          'student.cat_id.required' => 'Select one of the Category',
          'student.religion.required' => 'Please Mention Your Religion ',
          'student.nationality.required' => 'Please Fill Your natinality',
          'student.gender.required' => 'Gender Field is required ',
          'student.aadhar_no.required' => 'Aadhar no is Mandatory',
          'student.per_address.required' => 'Please Mention Your Permanent Address',
          'student.pincode.required' => 'Pincode field is required',
        ];
        return $msgs;
    }

    public function save()
    {
        $student = \App\Student::findOrFail($this->id);
        $student->fill($this->student);
        // dd($student);
        $student->update();
        $student_id = $student->id;
    }

    public function redirect()
    {
        if ($this->ajax()) {
            if ($this->id) {
                return reply("Student Updated Successfully", ['student_id' => $this->student_id]);
            }
        }
    }
}
