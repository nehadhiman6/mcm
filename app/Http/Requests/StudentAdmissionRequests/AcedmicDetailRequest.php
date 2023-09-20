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

class AcedmicDetailRequest extends FormRequest
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
        $this->course = Course::findOrFail($this->course_id);

        $rules = [
            'acades.*.result' => 'required|in:PASS,FAIL,COMPARTMENT,RESULT AWAITED,RL',
            'acades.*.institute' => 'required',
            'acades.*.board_id' => 'required',
            'acades.*.rollno' => 'required',
            'acades.*.year' => 'required',
            'acades.*.cgpa' => 'required',
            'acades.*.total_marks' => 'required_if:acades.*.result,PASS',
            'acades.*.division' => 'required_if:acades.*.result,PASS',
            'acades.*.reappear_subjects' => 'required_if:acades.*.result,COMPARTMENT',
            'acades.*.marks_obtained' => 'required_if:acades.*.result,PASS',
            'acades.*.marks_per' => 'required_if:acades.*.result,PASS',
            'acades.*.subjects' => 'required',
            'acades.*.other_exam' => 'required_if:acades.*.exam,Others',
            'acades.*.other_board' => 'required_if:acades.*.board_id,0',
            'acades.*.inst_state_id' => 'required',
        ];

        $ocet_validation_req = $this->has('ocet_rollno') ? true : false;
        $has_filled_ocet_details = false;
        foreach ($this->acades as $key => $detail) {
            if (data_get($detail, 'id', 0) > 0) {
                $rules["acades.$key.exam"] = 'required|unique:' . getYearlyDbConn() . '.academic_detail,exam,' . $detail['id'] . ',id,admission_id,' . $this->id;
            } else {
                $rules["acades.$key.exam"] = 'required|unique:' . getYearlyDbConn() . '.academic_detail,exam,null,id,admission_id,' . $this->id;
            }
            if ($detail['result']== 'PASS' && $detail['total_marks'] > 0 && $detail['marks_obtained'] > 0) {
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
            if ($detail['exam'] == "O-Cet Examination") {
                $has_filled_ocet_details = true;
            }
        }

        if ($ocet_validation_req && $has_filled_ocet_details == false) {
            $rules['ocet_exam_det'] = 'required';
        }


        if ($this->disqualified == 'Y') {
            $rules['disqualify_detail'] = "required";
        }

        if ($this->sports == 'Y' || $this->academic == 'Y' || $this->cultural == 'Y') {
            $rules['spl_achieve'] = "required";
        }

        if (intval($this->course_id) > 0) {
            $this->course = \App\Course::find($this->course_id);
            if ($this->course) {
                if ($this->course->course_year > 1) {
                    $rules['pupin_no'] = "required";
                    $rules['pu_regno'] = "required";
                }
            }
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

        return $rules;
    }

    public function messages()
    {
        $msgs = [
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
            'ocet_exam_det.required' => 'Provide Ocet Exam details'
        ];
        return $msgs;
    }
}
