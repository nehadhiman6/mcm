<?php

namespace App\Http\Controllers\Online;

use DB;
use Gate;
use Carbon\Carbon;
use App\StudentUser;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class FinalSubmissionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $adm_form = \App\AdmissionForm::where('std_user_id', auth()->user()->id)->first();
        $paid  = true;
        $msg = '';

        if (!$adm_form->collgeFeesPaid()) {
            $msg = '<h4>Processing Fee is Still Pending  Pay your Processing Fee Before Final Submission.</h4>';
            $paid = false;
        }
        // if (!$adm_form->hostelFeesPaid()) {
        //     $msg .= 'Hostel Processing Fee is Still Pending  Pay your Hostel Processing Fee Before Final Submission.';
        //     $paid = false;
        // }
        if (!$paid) {
            flash()->warning($msg);
            return redirect('admforms/' . $adm_form->id . '/details');
        }

        return view('online.admissions.final_formsubmission', compact('adm_form'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Final Submission Of Admission Form If Processing Fees is Paid.
     *
     */
    public function confirmSubmission(Request $request, $id)
    {
        $adm_form = \App\AdmissionForm::findOrFail($id);
        // dd($adm_form);
        $course = \App\Course::findOrFail($adm_form->course_id);
        $request->course_code = $course->course_code;

        if (Gate::denies('student-adm-form', $adm_form)) {
            abort('401', 'Resource does not belong to current user!!');
        }
        if ($adm_form->final_submission == 'Y' &&  $adm_form->attachment_submission == 'Y') {
            flash()->info('You have already submitted the form!!');
            return redirect()->back();
        }
        $acades = $adm_form->academics->toArray();
        $course_id_pool = $adm_form->course->course_id;
        $this->validator($adm_form->attributesToArray() + ['acades' => $acades] + ['course' => $adm_form->course] + ['course_id_pool' => $course_id_pool])->validate();
        // if (!$adm_form->feesPaid()) {
        //     return redirect('stulogin')->with('message', 'Processing Fee is Still Pending  Pay your Processing Fee Before Final Submission.');
        // }
        if ($adm_form->attachments()->whereIn('file_type', ['photograph', 'signature'])->count() < 2) {
            return redirect()->back()->with('message', 'Upload Student Photograph ,Student Signature to Complete the Submission Of Your Application');
        }
        // if ($adm_form->hostel == 'Y') {
        //     if ($adm_form->attachments()->whereIn('file_type', ['hostel_certificate'])->count() < 1) {
        //         return redirect()->back()->with('message', 'Upload hostel medical certificate to Complete the Submission Of Your Application');
        //     }
        // }

        if ($adm_form->belongs_bpl == 'Y') {
            if ($adm_form->attachments()->whereIn('file_type', ['bpl_certificate'])->count() < 1) {
                return redirect()->back()->with('message', 'Upload BPL Affidavit to Complete the Submission Of Your Application');
            }
        }

        DB::connection(getYearlyDbConn())->beginTransaction();
        $adm_form->final_submission = 'Y';
        $adm_form->attachment_submission = 'Y';
        $adm_form->submission_time = Carbon::now();
        if ($adm_form->std_id != 0 && $adm_form->status == 'A') {
            $student = \App\Student::whereId($adm_form->std_id)->first();
            $student->per_address = $adm_form->per_address;
            $student->city = $adm_form->city;
            $student->blood_grp = $adm_form->blood_grp;
            $student->minority = $adm_form->minority;
            $student->religion = $adm_form->religion;
            $student->other_religion = $adm_form->other_religion;
            $student->geo_cat = $adm_form->geo_cat;
            // $student->nationality = $adm_form->nationality;
            $student->name = $adm_form->name;
            $student->mobile = $adm_form->mobile;
            $student->aadhar_no = $adm_form->aadhar_no;
            $student->epic_no = $adm_form->epic_no;
            $student->gender = $adm_form->gender;
            $student->father_name = $adm_form->father_name;
            $student->mother_name = $adm_form->mother_name;
            $student->guardian_name = $adm_form->guardian_name;
            $student->dob = $adm_form->dob;
            $student->migration = $adm_form->migration;
            $student->hostel = $adm_form->hostel;
            $student->per_address = $adm_form->per_address;
            $student->city = $adm_form->city;
            $student->state_id = $adm_form->state_id;
            $student->pincode = $adm_form->pincode;
            $student->same_address = $adm_form->same_address;
            $student->corr_address = $adm_form->corr_address;
            $student->corr_city = $adm_form->corr_city;
            $student->corr_state_id = $adm_form->corr_state_id;
            $student->corr_pincode = $adm_form->corr_pincode;
            $student->father_occup = $adm_form->father_occup;
            $student->father_desig = $adm_form->father_desig;
            $student->father_phone = $adm_form->father_phone;
            $student->father_mobile = $adm_form->father_mobile;
            $student->f_office_addr = $adm_form->f_office_addr;
            $student->f_office_addr = $adm_form->f_office_addr;

            $student->father_email = $adm_form->father_email;
            $student->mother_occup = $adm_form->mother_occup;
            $student->mother_desig = $adm_form->mother_desig;
            $student->mother_phone = $adm_form->mother_phone;
            $student->mother_mobile = $adm_form->mother_mobile;
            $student->mother_email = $adm_form->mother_email;
            $student->m_office_addr = $adm_form->m_office_addr;
            $student->guardian_occup = $adm_form->guardian_occup;
            $student->guardian_desig = $adm_form->guardian_desig;
            $student->guardian_phone = $adm_form->guardian_phone;
            $student->guardian_mobile = $adm_form->guardian_mobile;
            $student->guardian_email = $adm_form->guardian_email;
            $student->g_office_addr = $adm_form->g_office_addr;
            $student->annual_income = $adm_form->annual_income;
            $student->pu_regno = $adm_form->pu_regno;
            $student->pu_regno2 = $adm_form->pu_regno2;
            $student->pupin_no = $adm_form->pupin_no;
            $student->org_migrate = $adm_form->org_migrate;
            $student->migrated = $adm_form->migrated;
            $student->migrate_detail = $adm_form->migrate_detail;
            $student->disqualified = $adm_form->disqualified;
            $student->disqualify_detail = $adm_form->disqualify_detail;
            $student->sports = $adm_form->sports;
            $student->cultural = $adm_form->cultural;
            $student->academic = $adm_form->academic;
            $student->foreign_national = $adm_form->foreign_national;
            $student->f_nationality = $adm_form->f_nationality;
            $student->foreign_national = $adm_form->foreign_national;
            $student->passportno = $adm_form->passportno;
            $student->visa = $adm_form->visa;
            $student->res_permit = $adm_form->res_permit;
            $student->update();
        }
        // dd($adm_form);
        $adm_form->update();
        //    if ($student = $adm_form->student) {
        //
        //    }
        if($adm_form->course->course_year == 1 && $adm_form->course->status == "GRAD"){
            // 1111
            $std_user= StudentUser::find($adm_form->std_user_id);
            $subj = 'Thanks for choosing our college';
            $mail_msg = "<p>Dear Applicant </p></br>
            <p>Greetings from Mehr Chand Mahajan DAV College for Women, Chandigarh.</p></br>
            <p>As you are going to step into college life, we take this opportunity to congratulate you for your achivement - in school 12th exams and for choosing one of the best colleges in India.
            We Welcome you to MCMDAV family.</p></br> 
            <p>Wishing for a fruitful Association with you!</p></br>
            <p>Regards </p></br>
            <p>Principal</p></br>
            <p>Dr. Nisha Bhargava</p>";
            $email = $this->sendEmail($std_user->email, $subj,$mail_msg);
        }
       
        DB::connection(getYearlyDbConn())->commit();
        flash()->success('You Have Successfully Submitted Your Form');
        return redirect('admforms/' . $adm_form->id . '/details');
    }

    public function sendEmail($email,$subj,$msg)
    {
        // dd($email,$subj,$msg);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Mail::to($email)->send(new SendMail($subj,$msg));
        } else {
            if (strlen(trim($email)) > 4) {
                return "$email not a valid E-mail Address";
            }
        }
    }
    protected function validator(array $data)
    {
        $showPoolCourses = ['BCA','BBA','BCOM','BSC','BCOM-SF','MCOM','MSC','BSC-COMP','BSC-NMED','BSC-MED','MSC-COMP','MSC-MATH','MSC-CHEM'];
        // dd($data);

        $rules =  [
            // 'loc_cat' => 'required_if:course_code,BCAI,BCAII,BCAIII,BBAI,BBAII,BBAIII,BCOMI,BCOMII,BCOMIII,BSCI,BSCII,BSCIII,BSC-I MFT,BSC-II MFT,BSC-III MFT,MCOMI,MCOMII,MCOMIII,MSC-I CHEM,MSC-II CHEM,MSC-MATH,MSC-II MATH|in:General,UT',
            // 'loc_cat' => 'required_if:course_id_pool,BCA,BBA,BCOM,BSC,BCOM-SF,MCOM,MSC,BSC-COMP,BSC-NMED,BSC-MED,MSC-COMP,MSC-MATH,MSC-CHEM|in:General,UT',

            'cat_id' => 'required|exists:categories,id',
            'course_id' => 'required|exists:' . getYearlyDbConn() . '.courses,id',
            'resvcat_id' => 'required|exists:res_categories,id',

            // 'religion' => 'required',
            'geo_cat' => 'required',
            'nationality' => 'required',
            'name' => 'required',
            'mobile' => 'required|min:10|max:10|regex:/^[0-9]+$/',
            // 'aadhar_no' => 'required|min:12|max:12',
            'gender' => 'required|in:Male,Female,Transgender',
            'father_name' => 'required',
            'mother_name' => 'required',
            'blood_grp' => 'required',
            // 'guardian_name' => 'required',
            'dob' => 'required|date_format:d-m-Y',
            'per_address' => 'required',
            'pincode' => 'required|min:6|max:6|regex:/^[0-9]+$/',
            'terms_conditions' => 'required|in:Y',
            'acades.*.result' => 'required|in:PASS,FAIL,COMPARTMENT,RESULT AWAITED,RL',
            'acades.*.institute' => 'required',
            'acades.*.inst_state_id' => 'required',
            'acades.*.board_id' => 'required',
            'acades.*.rollno' => 'required',
            'acades.*.year' => 'required',
            'acades.*.total_marks' => 'required_if:acades.*.result,PASS',
            'acades.*.marks_obtained' => 'required_if:acades.*.result,PASS',
            'acades.*.marks_per' => 'required_if:acades.*.result,PASS',
            'acades.*.subjects' => 'required',
            'acades.*.other_exam' => 'required_if:acades.*.exam,Others',
            'acades.*.other_board' => 'required_if:acades.*.board_id,0'
        ];

        if (in_array($data['course_id_pool'], $showPoolCourses)) {
            $rules['loc_cat'] = 'required|in:General,UT';
        }

        // if (intval($data['course']->course_year) == 1) {
        //     $rules['lastyr_rollno'] = 'required|integer|min:1|unique:' . getYearlyDbConn() . '.admission_forms,lastyr_rollno,null,id,final_submission,Y';
        // }

        return Validator::make($data, $rules, $messages = [
            'lastyr_rollno.required' => 'Fill your roll number!',
            'lastyr_rollno.min' => 'Fill your roll number!',
            'loc_cat.required' => 'Select one of the Relevant Category',
            'geo_cat.required' => 'Select one of the for information field',
            'resvcat_id.required' => 'Reserved Category field is required',
            'name.required' => 'Please Mention Your Full Name',
            'aadhar_no.required' => 'AAdhar No. Field is Mandatory',
            'cat_id.required' => 'Select one of the Category',
            'dob.required' => 'Please fill your Date Of Birth',
            'per_address.required' => 'Please Fill permanent address field',
            'comp_group.required' => 'Check ! In each Compulsory Group One subject should be selected',
            'acades.*.exam.required' => 'Exam Field Can not be left Blank',
            'acades.*.result.required' => 'Result Field Can not be left Blank',
            'acades.*.exam.unique' => 'This Exam Has Already been Filled Try Another.',
            'acades.*.other_exam.required_if' => 'If Others Exam Selected. Please Mention Your ExamName.',
            'acades.*.institute.required' => 'Institute Field Can not be left Blank',
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
            'terms_conditions.in' => 'You Have To Agree With the Terms And Conditions',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
