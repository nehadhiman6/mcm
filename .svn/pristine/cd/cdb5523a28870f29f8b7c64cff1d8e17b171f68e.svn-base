<?php

namespace App\Http\Controllers\Alumni;

use Illuminate\Http\Request;
use App\AlumniStudent;
use App\AlumniExperience;
use App\AlumniQualification;
use DB;
use Illuminate\Support\Facades\Auth;
use App\AlumniMeetStudent;
use App\AlumniAward;
use Illuminate\Support\Facades\Gate;
use App\AlumniMeet;

// use App\Http\Controllers\Controller;

class AlumaniStuFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth('alumnies')->check()) {
            $alumni_user = auth()->user();
            $alm_form = AlumniStudent::where('alumni_user_id', $alumni_user->id)->first();
            if ($alm_form) {
                return redirect('alumni-student/' . $alm_form->id . '/details');
            } elseif ($alumni_user->reg_code) {
                $alm_form = AlumniStudent::whereRegCode($alumni_user->reg_code)
                    ->where('alumni_user_id', 0)
                    ->first();
                if ($alm_form) {
                    $alm_form->alumni_user_id = $alumni_user->id;
                    $alm_form->save();
                    return redirect('alumni-student/' . $alm_form->id . '/details');
                }
            }
        }
        return view('alumni.create');
    }


    public function details($id)
    {
        $alumni = AlumniStudent::findOrFail($id);
        if (Gate::denies('alumni-student-user', $alumni)) {
            abort('401', 'Resource does not belong to current alumni!!');
        }
        $alumni->load('graduatecourse', 'postgradcourses', 'professionalcourses', 'researches');
        // dd($alumni);
        return view('alumni.details', compact('alumni'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function validateForm($request, $id = 0)
    {
        $rules = [
            'name' => 'required',
            'gender' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'passout_year' => 'integer|required|digits:4',
            'dob' => 'date|date_format:d-m-Y',
            'email' => 'required|email|max:255',
            'phone' => 'integer',
            'mobile' => 'integer|digits:10',
            'remarks' => 'nullable|max:200',
            'per_address' => 'required',
            'ugc_qualified' => 'required|in:"Y","N"',
            'award_yes_no' => 'required|in:"Y","N"',
            'member_yes_no' => 'required|in:"Y","N"',
            'reason_yes_no' => 'required|in:"Y","N"',
            'ugc_year' => 'nullable|required_if:ugc_qualified,Y|numeric|digits:4',
            'ugc_subject_name' => 'required_if:ugc_qualified,Y',
            'competitive_exam_qualified' => 'required|in:Y,N',
            'competitive_exam_year' => 'nullable|required_if:competitive_exam_qualified,Y|numeric|digits:4',
            'graduatecourse.*.course_id' => 'required|min:1|not_in:0',
            'graduatecourse.*.degree_type' => 'required|in:UG',
            'graduatecourse.*.passing_year' => 'required|min:4|max:4|digits:4',
            'graduatecourse.*.mcm_college' => 'required|in:Y,N',
            'graduatecourse.*.other_course' => 'required_if:graduatecourse.*.course_id,"-1"',
            'graduatecourse.*.other_institute' => 'required_if:graduatecourse.*.mcm_college,"N"',
            //post graduatation
            'postgraduatecourses.*.degree_type' => 'required|in:"PG"',
            'postgraduatecourses.*.mcm_college' => 'required|in:"Y","N"',
            'postgraduatecourses.*.passing_year' => 'required_unless:postgraduatecourses.*.course_id,0|min:4|max:4|digits:4',
            'postgraduatecourses.*.other_course' => 'required_if:postgraduatecourses.*.course_id,"-1"',
            'postgraduatecourses.*.other_institute' => 'required_if:postgraduatecourses.*.mcm_college,"N"',


            //professionalCourses
            'professionaldegrees.*.degree_type' => 'required_unless:professionaldegrees.*.course_id,0|in:"professional"',
            'professionaldegrees.*.passing_year' => 'required_unless:professionaldegrees.*.course_id,0|digits:4',
            'professionaldegrees.*.mcm_college' => 'required_unless:professionaldegrees.*.course_id,0|in:"Y","N"',
            'professionaldegrees.*.other_course' => 'required_if:professionaldegrees.*.course_id,"-1"',
            'professionaldegrees.*.other_institute' => 'required_if:professionaldegrees.*.mcm_college,"N"',

            //research
            'researchdegrees.*.degree_type' => 'required_unless:researchdegrees.*.course_id,0|in:"research"',
            'researchdegrees.*.passing_year' => 'required_unless:researchdegrees.*.course_id,0|digits:4',
            'researchdegrees.*.mcm_college' => 'required_unless:researchdegrees.*.course_id,0|in:"Y","N"',
            'researchdegrees.*.other_course' => 'required_if:researchdegrees.*.course_id,"-1"',
            'researchdegrees.*.other_institute' => 'required_if:researchdegrees.*.mcm_college,"N"',
            'researchdegrees.*.research_area' => 'required_unless:researchdegrees.*.course_id,0',

        ];
        // dd($request->all());
        if ($request->award_yes_no == 'Y') {
            $rules += [
                'awards.*.award_name' => 'required_if:award_yes_no,"Y"|string|max:100',
                'awards.*.award_field' => 'required_if:award_yes_no,"Y"|string|max:100',
                'awards.*.award_year' => 'required_if:award_yes_no,"Y"|numeric|digits:4',
            ];
        }

        if ($request->member_yes_no == 'Y') {
            $rules += [
                'payment_amount' => 'required_if:donation_yes_no,"Y"|numeric',

            ];
        }

        if ($request->reason_yes_no == 'Y') {
            $rules += [
                'donation_reason' => 'required_if:reason_yes_no,"Y"|string',
            ];
            if ($request->donation_reason == 'Others') {
                $rules += [
                    'donation_other' => 'required_if:donation_reason,"Others"|string|max:100',
                ];
            }
        }



        foreach ($request->postgraduatecourses as $pgrad) {
            if ($pgrad['course_id'] > 0) {
                $rules += ['postgraduatecourses.*.course_id' => 'distinct|required|min:1'];
            } else {
                $rules += ['postgraduatecourses.*.course_id' => 'required|min:1'];
            }
        }

        foreach ($request->professionaldegrees as $prof) {
            if ($prof['course_id'] > 0) {
                $rules += ['professionaldegrees.*.course_id' => 'distinct'];
            }
        }

        foreach ($request->researchdegrees as $research) {
            if ($research['course_id'] > 0) {
                $rules += ['researchdegrees.*.course_id' => 'distinct'];
            }
        }
        foreach ($request->experience as $exp) {
            if ($exp['org_name'] != '') {
                if ($exp['currently_working'] == "N") {
                    // $rules+= ['experience.*.end_date'.$exp['currently_working']=>'required'];
                }
            }
            if ($exp['org_name'] != '') {
                $rules += ['experience.*.num_of_employees' => 'required_if:experience.*.emp_type,"self-employed"'];
                $rules += ['experience.*.org_address' => 'required_if:experience.*.emp_type,"self-employed"'];
                $rules += ['experience.*.designation' => 'required_if:experience.*.emp_type,"salaried"'];
                $rules += ['experience.*.start_date' => 'required_unless:experience.*.org_name,""'];
                $rules += ['experience.*.area_of_work' => 'required_if:experience.*.emp_type,"charity"'];
            }
        }

        if ($request->competitive_exam_qualified == "Y" && $request->competitive_exam_id == 0) {
            $rules += ['competitive_exam_id' => 'required|notIn:0'];
        }

        if ($request->competitive_exam_id  == "-1") {
            $rules += ['other_competitive_exam' => 'required'];
        } elseif ($request->competitive_exam_id  == "1" || $request->competitive_exam_id  == "2") {
            $rules += ['upsc_psu_exam_name' => 'required'];
        }
        $msgs = [
            'name.required' => 'Name is Mandatory',
            'gender.required' => 'Gender Field is Mandatory',
            'father_name.required' => 'Father Name Field is Mandatory',
            'mother_name.required' => 'Mother Field is Mandatory',
            'passout_year.required' => 'Passing Year Field is Mandatory',
            'passout_year.digits' => 'Invalid year',
            'passout_year.integer' => 'Please Enter valid year',
            'dob.date' => 'Not a Valid Date',
            'email.email' => 'Enter valid Email',
            'phone.integer' => 'Enter Valid Phone Number',
            'mobile.integer' => 'Enter Valid Mobile',
            'mobile.digits' => 'Enter Valid Mobile',
            'per_address.required' => 'Address Field is Mandatory',
            'ugc_qualified.required' => 'UGC Field is Mandatory',
            'ugc_subject_name.required_if' => 'UGC Subject Field is Mandatory',
            'competitive_exam_qualified.required' => 'Competitive Field is Mandatory',
            'upsc_psu_exam_name.required' => 'Please mention name of service',
            'graduatecourse.*.course_id.required' => 'Course Field is Mandatory',
            'graduatecourse.*.course_id.not_in' => 'Select Graduate Course',
            'graduatecourse.*.course_id.in' => 'Field is Mandatory',
            'graduatecourse.*.passing_year.required' => 'Course Year Field is Mandatory',
            'graduatecourse.*.mcm_college.required' => 'College Field is Mandatory',
            'graduatecourse.*.other_course.required_if' => 'Other course Field is Mandatory',
            'graduatecourse.*.other_institute.required_if' => 'Other institute Field is Mandatory',
            //post graduatation
            'postgraduatecourses.*.course_id.required' => 'Course Field is Mandatory',
            'postgraduatecourses.*.course_id.distinct' => 'Course already entered. Please select another course ',
            'postgraduatecourses.*.mcm_college.required' => 'College Field is Mandatory',
            'postgraduatecourses.*.passing_year.required_unless' => 'Passing year Field is Mandatory',
            'postgraduatecourses.*.other_course.required_if' => 'Other course Field is Mandatory',
            'postgraduatecourses.*.other_institute.required_if' => 'Other Institute Field is Mandatory',


            //professionalCourses
            'professionaldegrees.*.degree_type.required_unless' => 'Course Field is Mandatory',
            'professionaldegrees.*.course_id.distinct' => 'Course already entered. Please select another course ',
            'professionaldegrees.*.passing_year.required_unless' => 'Passing year  Field is Mandatory',
            'professionaldegrees.*.mcm_college.required_unless' => 'College Field is Mandatory',
            'professionaldegrees.*.other_course.required_if' => 'Other course Field is Mandatory',
            'professionaldegrees.*.other_institute.required_if' => 'Other Institute Field is Mandatory',

            //research
            'researchdegrees.*.degree_type.required_unless' => ' Field is Mandatory',
            'researchdegrees.*.course_id.distinct' => 'Course already entered. Please select another course ',
            'researchdegrees.*.passing_year.required_unless' => 'Research degree year Field is Mandatory',
            'researchdegrees.*.mcm_college.required_unless' => 'Research Institute Field is Mandatory',
            'researchdegrees.*.other_course.required_if' => 'Research Field is Mandatory',
            'researchdegrees.*.other_institute.required_if' => 'Research institute Field is Mandatory',
            'researchdegrees.*.research_area.required_unless' => 'Research Area Field is Mandatory',

            //work Experience
            'experience.*.designation.required_if' => 'Designation Field is Mandatory',
            'experience.*.start_date.required_unless' => 'Start Date Field is Mandatory',
            'experience.*.end_date.required' => 'Leave Date Field is Mandatory',
            'experience.*.num_of_employees.required_if' => 'Number of Employees Field is Mandatory',
            'experience.*.org_address.required_if' => "Organization Address Field is Mandatory",
            'experience.*.area_of_work.required_if' => 'Area of research is Mandatory',

            //awards
            'awards.*.award_name.required_if' => 'Name is Mandatory',
            'awards.*.award_name.max' => 'Name must be under 100 charachters',
            'awards.*.award_field.required_if' => 'Field is Mandatory',
            'awards.*.award_field.max' => 'Field must be under 100 charachters',
            'awards.*.award_year.required_if' => 'Year is Mandatory',
            'awards.*.award_year.numeric' => 'Year must be numeric',
            'awards.*.award_year.digits' => 'Enter 4 digits yaer'
        ];


        $this->validate($request, $rules, $msgs);
    }
    private function validateForm1($request, $id = 0)
    {
        $rules = [
            'name' => 'required',
            'gender' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'passout_year' => 'integer|required|digits:4',
            'dob' => 'date|date_format:d-m-Y',
            'email' => 'required|email|max:255',
            'phone' => 'integer',
            'mobile' => 'integer|digits:10',
            'per_address' => 'required',
            'graduatecourse.*.course_id' => 'required|min:1|not_in:0',
            'graduatecourse.*.degree_type' => 'required|in:"UG"',
            'graduatecourse.*.passing_year' => 'required|min:4|max:4',
            'graduatecourse.*.mcm_college' => 'required|in:"Y","N"',
            'graduatecourse.*.other_course' => 'required_if:graduatecourse.*.course_id,"-1"',
            'graduatecourse.*.other_institute' => 'required_if:graduatecourse.*.mcm_college,"N"',

            //post graduatation
            'postgraduatecourses.*.degree_type' => 'required|in:"PG"',
            'postgraduatecourses.*.mcm_college' => 'required|in:"Y","N"',
            'postgraduatecourses.*.passing_year' => 'required_unless:postgraduatecourses.*.course_id,0|min:4|max:4',
            'postgraduatecourses.*.other_course' => 'required_if:postgraduatecourses.*.course_id,"-1"',
            'postgraduatecourses.*.other_institute' => 'required_if:postgraduatecourses.*.mcm_college,"N"',
            'graduatecourse.*.course_id.required' => 'Course Field is Mandatory',
            'graduatecourse.*.course_id.not_in' => 'Select Graduate Course',
            'graduatecourse.*.course_id.in' => 'Field is Mandatory',
            'graduatecourse.*.passing_year.required' => 'Course Year Field is Mandatory',
            'graduatecourse.*.mcm_college.required' => 'College Field is Mandatory',
            'graduatecourse.*.other_course.required_if' => 'Other course Field is Mandatory',
            'graduatecourse.*.other_institute.required_if' => 'Other institute Field is Mandatory',
            //post graduatation
            'postgraduatecourses.*.course_id.required' => 'Course Field is Mandatory',
            'postgraduatecourses.*.course_id.distinct' => 'Course already entered. Please select another course ',
            'postgraduatecourses.*.mcm_college.required' => 'College Field is Mandatory',
            'postgraduatecourses.*.passing_year.required_unless' => 'Passing year Field is Mandatory',
            'postgraduatecourses.*.other_course.required_if' => 'Other course Field is Mandatory',
            'postgraduatecourses.*.other_institute.required_if' => 'Other Institute Field is Mandatory',

        ];

        $msgs = [
            'name.required' => 'Name is Mandatory',
            'gender.required' => 'Gender Field is Mandatory',
            'father_name.required' => 'Father Name Field is Mandatory',
            'mother_name.required' => 'Mother Field is Mandatory',
            'passout_year.required' => 'Passing Year Field is Mandatory',
            'passout_year.digits' => 'Invalid year',
            'passout_year.integer' => 'Please Enter valid year',
            'dob.date' => 'Not a Valid Date',
            'email.email' => 'Enter valid Email',
            'phone.integer' => 'Enter Valid Phone Number',
            'mobile.integer' => 'Enter Valid Mobile',
            'mobile.digits' => 'Enter Valid Mobile',
            'per_address.required' => 'Address Field is Mandatory',
        ];

        $this->validate($request, $rules, $msgs);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loginUserId =  Auth::user()->id;
        $this->validateForm($request);
        $alm_student = new AlumniStudent();
        $alm_student->fill($request->all());
        $alm_student->alumni_user_id = $loginUserId;

        $alm_qualifications = new \Illuminate\Database\Eloquent\Collection();
        foreach ($request->graduatecourse as $graduatecourse) {
            if ($graduatecourse['course_id'] > 0 || $graduatecourse['course_id'] == '-1') {
                $grad = new AlumniQualification();
                $grad->fill($graduatecourse);
                if ($grad['mcm_college'] == "Y") {
                    $grad['other_institute'] = null;
                }
                $alm_qualifications->add($grad);
            }
        }

        foreach ($request->postgraduatecourses as $postgraduatecourse) {
            if ($postgraduatecourse['course_id'] > 0 || $postgraduatecourse['course_id'] == '-1') {
                $pg_grad = new AlumniQualification();
                $pg_grad->fill($postgraduatecourse);
                if ($pg_grad['mcm_college'] == "Y") {
                    $grad['other_institute'] = null;
                }
                $alm_qualifications->add($pg_grad);
            }
        }

        foreach ($request->professionaldegrees as $professionaldegree) {
            if ($professionaldegree['course_id'] > 0 || $professionaldegree['course_id'] == '-1') {
                $prof = new AlumniQualification();
                $prof->fill($professionaldegree);
                if ($prof['mcm_college'] == "Y") {
                    $prof['other_institute'] = null;
                }
                $alm_qualifications->add($prof);
            }
        }
        foreach ($request->researchdegrees as $researchdegree) {
            if ($researchdegree['course_id'] > 0 || $researchdegree['course_id'] == '-1') {
                $research = new AlumniQualification();
                $research->fill($researchdegree);
                if ($research['mcm_college'] == "Y") {
                    $research['other_institute'] = null;
                }
                $alm_qualifications->add($research);
            }
        }
        $alm_experiences = new \Illuminate\Database\Eloquent\Collection();
        foreach ($request->experience as $exp) {
            if ($exp['org_name'] != '') {
                $exprnce = new AlumniExperience();
                $exprnce->fill($exp);
                if ($exprnce['currently_working'] == "Y") {
                    // $exprnce['end_date'] = null;
                }
                $alm_experiences->add($exprnce);
            }
        }

        $alm_awards = new \Illuminate\Database\Eloquent\Collection();
        foreach ($request->awards as $award) {
            if ($award['award_name'] != '') {
                $awrd = new AlumniAward();
                $awrd->alumni_stu_id = $alm_student->id;
                $awrd->fill($award);
                $alm_awards->add($awrd);
            }
        }

        if ($request->meet) {
            $alm_meet = new AlumniMeetStudent();
            $alm_meet->meet_id = $request->meet;
            $alm_meet->attending_meet = $request->attending_meet;
        }

        DB::beginTransaction();
        $alm_student->save();
        $alm_student->almqualification()->saveMany($alm_qualifications);
        // $alm_student->almexperience()->saveMany($alm_experiences);
        $alm_student->almAward()->saveMany($alm_awards);
        if ($request->meet) {
            $alm_meet->alumni_stu_id = $alm_student->id;
            $alm_meet->save();
        }
        DB::commit();

        return response()->json([
            'success' => true,
            'form_id' => $alm_student->id
        ]);
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

        $alm_student = AlumniStudent::findOrFail($id);
        if (Gate::denies('alumni-student-user', $alm_student)) {
            abort('401', 'Resource does not belong to current alumni!!');
        }
        $alm_student->load(['graduatecourse', 'postgradcourses', 'professionalcourses', 'researches', 'almexperience', 'alumnimeet.meet']);
        // dd($alm_student);
        return view('alumni.create', compact('alm_student'));
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
        $this->validateForm($request);
        $alm_student = AlumniStudent::findOrFail($id);
        $alm_student->fill($request->all());


        $alm_qualifications = new \Illuminate\Database\Eloquent\Collection();
        foreach ($request->graduatecourse as $graduatecourse) {
            if ($graduatecourse['course_id'] > 0 ||  $graduatecourse['course_id'] == 'others') {
                if (isset($graduatecourse['id']) && $graduatecourse['id'] && $graduatecourse['id'] > 0) {
                    $grad = AlumniQualification::findOrFail($graduatecourse['id']);
                } else {
                    $grad = new AlumniQualification();
                }
                $grad->fill($graduatecourse);
                $alm_qualifications->add($grad);
            }
        }

        foreach ($request->postgraduatecourses as $postgraduatecourse) {
            if ($postgraduatecourse['course_id'] > 0 || $postgraduatecourse['course_id'] == 'others') {
                if (isset($postgraduatecourse['id']) && $postgraduatecourse['id'] > 0) {
                    $pg_grad = AlumniQualification::findOrFail($postgraduatecourse['id']);
                } else {
                    $pg_grad = new AlumniQualification();
                }
                $pg_grad->fill($postgraduatecourse);
                if ($grad['mcm_college'] == "Y") {
                    $grad['other_institute'] = null;
                }
                $alm_qualifications->add($pg_grad);
            }
        }

        foreach ($request->professionaldegrees as $professionaldegree) {
            if ($professionaldegree['course_id'] > 0 || $professionaldegree['course_id'] == 'others') {
                if (isset($professionaldegree['id']) && $professionaldegree['id'] > 0) {
                    $prof = AlumniQualification::findOrFail($professionaldegree['id']);
                } else {
                    $prof = new AlumniQualification();
                }
                $prof->fill($professionaldegree);
                if ($prof['mcm_college'] == "Y") {
                    $prof['other_institute'] = null;
                }
                $alm_qualifications->add($prof);
            }
        }
        foreach ($request->researchdegrees as $researchdegree) {
            if ($researchdegree['course_id'] > 0 || $researchdegree['course_id'] == 'others') {
                if (isset($researchdegree['id']) && $researchdegree['id'] > 0) {
                    $research = AlumniQualification::findOrFail($researchdegree['id']);
                } else {
                    $research = new AlumniQualification();
                }
                $research->fill($researchdegree);
                if ($research['mcm_college'] == "Y") {
                    $research['other_institute'] = null;
                }
                $alm_qualifications->add($research);
            }
        }
        $alm_experiences = new \Illuminate\Database\Eloquent\Collection();
        // return $request->experience;
        foreach ($request->experience as $exp) {
            if ($exp['org_name'] != '') {
                if (isset($exp['id'])) {
                    $exprnce = AlumniExperience::findOrFail($exp['id']);
                } else {
                    $exprnce = new AlumniExperience();
                }
                if ($exp['currently_working'] == "Y") {
                    // $exp->end_date =  null;
                }

                $exprnce->fill($exp);
                $alm_experiences->add($exprnce);
            }
        }

        $alm_awards = new \Illuminate\Database\Eloquent\Collection();
        // return $request->experience;
        foreach ($request->awards as $award) {
            if ($award['award_name'] != '') {
                if (isset($award['id'])) {
                    $awrd = AlumniAward::findOrFail($award['id']);
                } else {
                    $awrd = new AlumniAward();
                    $awrd->alumni_stu_id = $alm_student->id;
                }
                $awrd->fill($award);
                $alm_awards->add($awrd);
            }
        }


        // if ($request->meet) {
        //     $alm_meet = AlumniMeetStudent::firstOrNew(['alumni_stu_id' => $alm_student->id, 'meet_id' => $request->meet]);
        //     $alm_meet->meet_id = $request->meet;
        //     $alm_meet->attending_meet = $request->attending_meet;
        // }

        $old_ids = $alm_student->almqualification->pluck('id')->toArray();
        $new_ids = $alm_qualifications->pluck('id')->toArray();
        $detach = array_diff($old_ids, $new_ids);

        $old_ids_exp = $alm_student->almexperience->pluck('id')->toArray();
        $new_ids_exp = $alm_experiences->pluck('id')->toArray();
        $detach_exp = array_diff($old_ids_exp, $new_ids_exp);

        $old_ids_awd = $alm_student->almAward->pluck('id')->toArray();
        $new_ids_awd = $alm_awards->pluck('id')->toArray();
        $detach_awd = array_diff($old_ids_awd, $new_ids_awd);

        DB::beginTransaction();
        $alm_student->update();

        $alm_student->almqualification()->saveMany($alm_qualifications);
        $alm_student->almexperience()->saveMany($alm_experiences);
        $alm_student->almAward()->saveMany($alm_awards);

        AlumniQualification::whereIn('id', $detach)->delete();
        AlumniExperience::whereIn('id', $detach_exp)->delete();
        AlumniAward::whereIn('id', $detach_awd)->delete();

        // if ($request->meet) {
        //     $alm_meet->alumni_stu_id = $alm_student->id;
        //     $alm_meet->save();
        // }
        DB::Commit();
        return response()->json([
            'success' => true,
            'form_id' => $alm_student->id

        ]);
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

    public function showDonation($id)
    {
        $alumni = AlumniStudent::findOrFail($id);
        if (Gate::denies('alumni-student-user', $alumni)) {
            abort('401', 'Resource does not belong to current alumni!!');
        }

        return view('alumni.show_donation', compact('alumni'));
    }

    public function goingAlumnieMeet(){
        if (auth('alumnies')->check()) {
            $alumni_user = auth()->user();
            $alm_form = AlumniStudent::where('alumni_user_id', $alumni_user->id)->first();
            // dd($alm_form);
            $alm_stu_id = $alm_form->id;
            $alumni_meet = AlumniMeet::orderBy('meet_date', 'desc')->where('active','=','Y')->first();
            $alm_meet_std = '';
            if($alumni_meet){
                $alm_meet_std = AlumniMeetStudent::where('alumni_stu_id',$alm_form->id)->where('meet_id',$alumni_meet->id)->first();
            }
            
            return view('alumni.going_alumni_meet', compact('alumni_meet','alm_stu_id','alm_meet_std'));
        }
    }

    public function meetJoinSave(Request $request){
        // dd($request->alumni_stu_id);
        $alm_form = AlumniMeetStudent::findOrNew($request->id);
        // dd();
        $alm_form->alumni_stu_id = $request->alumni_stu_id;
        $alm_form->meet_id = $request->meet_id;
        $alm_form->attending_meet = $request->attending_meet;
        // dd($alm_form);
        $alm_form->save();
        return response()->json([
            'success' => true,
            'alm_form' => $alm_form

        ]);
        
    }
}
