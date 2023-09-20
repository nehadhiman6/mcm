<?php

namespace App\Http\Requests\StudentAdmissionRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\AdmissionForm;
use App\Course;

class StudentDetailRequest extends FormRequest
{
    protected $course = null;
    protected $admsubs = [];
    protected $honour_subs = [];
    protected $adm_sub_prefs = [];
    protected $id = 0;
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
        $this->id = $this->form_id;
        if ($this->course_id > 0) {
            $this->course = Course::findOrFail($this->course_id);
        }



        $rules = [
            // 'loc_cat' => 'required_if:course_code,BCAI,BCAII,BCAIII,BBAI,BBAII,BBAIII,BCOMI,BCOMII,BCOMIII,BSCI,BSCII,BSCIII,BSC-I COMP,BSC-II COMP,BSC-III COMP,B.COM-I SF,B.COM-II SF,B.COM-III SF,MCOMI,MCOMII,MCOMIII,MSC-I CHEM,MSC-II CHEM,MSC-MATH,MSC-II MATH',
            'cat_id' => 'required|exists:categories,id',
            'course_id' => 'required|exists:' . getYearlyDbConn() . '.courses,id',
            'resvcat_id' => 'required|exists:res_categories,id',
            'conveyance' => 'required',
            // 'geo_cat' => 'required',
            'nationality' => 'required',
            'name' => 'required',
            'mobile' => 'required|min:10|max:10',
            // 'minority' => 'required|min:1',
            // 'aadhar_no' => 'required|min:12|max:12',
            'gender' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'blood_grp' => 'required',
            'dob' => 'required|date_format:d-m-Y',
            'per_address' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            // 'vaccinated' => 'required',

        ];

        $adm_form = AdmissionForm::find($this->form_id);
        $adm_entry = $adm_form ? $adm_form->admEntry : null;
        $showPoolCourses = ['BCA','BBA','BCOM','BSC','BCOM-SF','MCOM','MSC','BSC-COMP','BSC-NMED','BSC-MED','MSC-COMP','MSC-MATH','MSC-CHEM'];

        if ($this->course && $this->course->adm_open == 'N' && ! $adm_entry) {
            // dd('here');
            $rules['course'] = 'required';
            $course_id_pool = $this->course->course_id;
            if (in_array($course_id_pool, $showPoolCourses)) {
                $rules['loc_cat'] = 'required|in:General,UT';
            }
        }


        // if ($this->vaccinated == 'Not Yet') {
        //     $rules['vaccination_remarks'] = "required";
        // }

        if ($this->nationality == 'INDIAN') {
            $rules['state_id'] = 'required|exists:states,id';
        }

        foreach ($this->acades ? $this->acades : [] as $key => $detail) {
            // if (data_get($detail, 'id', 0) > 0) {
            //     $rules["acades.$key.exam"] = 'required|unique:' . getYearlyDbConn() . '.academic_detail,exam,' . $detail['id'] . ',id,admission_id,' . $this->id;
            // } else {
            //     $rules["acades.$key.exam"] = 'required|unique:' . getYearlyDbConn() . '.academic_detail,exam,null,id,admission_id,' . $this->id;
            // }
            if ($detail['marks_per'] > 0 && $detail['total_marks'] > 0 && $detail['marks_obtained'] > 0) {
                $marksper = (floatval($detail['marks_obtained']) * 100) / floatval($detail['total_marks']);
                $rules["acades.$key.marks_per"] = "numeric|min:" . floor($marksper) . "|max:" . ceil($marksper);
            }
            if ($detail['result'] != 'COMPARTMENT') {
                $detail['reappear_subjects'] = '';
            }
        }

        // nullable fields add blank value



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

        if ($this->disqualified == 'Y') {
            $rules['disqualify_detail'] = "required";
        }

        if ($this->last_last_exam_mcm == 'Y' && $this->course->course_year > 1) {
            $rules['lastyr_rollno'] = "required";
        }

        if ($this->course && ($this->course->course_year == 2 || $this->course->course_year == 3)) {
            $rules['boarder'] = "required";
        }
        return $rules;
    }

    public function messages()
    {
        $msgs = [
            'course.required' => 'Registration Closed For This Course!!',
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
        return $msgs;
    }
}
