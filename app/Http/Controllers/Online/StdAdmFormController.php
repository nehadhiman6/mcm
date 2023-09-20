<?php

namespace App\Http\Controllers\Online;

use App\Http\Requests\AdmissionFormRequest;
use Illuminate\Support\Facades\Gate;
use App\Course;
use App\StudentUser;
use Session;

class StdAdmFormController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth('students')->check()) {
            $adm_form = \App\AdmissionForm::where('std_user_id', auth()->user()->id)->first();
            if ($adm_form) {
                return redirect('admforms/' . $adm_form->id . '/details');
            }
        }
        return view('admissionform.create');
    }

    /**
     *
     *
     * Show the form for creating a new resource.
     * *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdmissionFormRequest $request)
    {
        $request->save();
        return $request->redirect();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = \App\AdmissionForm::findOrFail($id);
        //$comp_subjects = $student->course->subjects;
        if (Gate::denies('student-adm-form', $student)) {
            abort('401', 'Resource does not belong to current user!!');
        }
        $student = $student->load('academics');
        $preview = new \App\Printings\AdmFormPrintPdf();
        $pdf = $preview->makepdf($student);
        $pdf->Output("Preview$student->id.pdf", 'I');
        // return view('admissionform.preview_detail', compact('student', 'comp_subjects'));
    }

    public function showHostel($id)
    {
        $student = \App\AdmissionForm::findOrFail($id);
        //$comp_subjects = $student->course->subjects;
        if (Gate::denies('student-adm-form', $student)) {
            abort('401', 'Resource does not belong to current user!!');
        }
        $student = $student->load('academics');
        $preview = new \App\Printings\HostelForm();
        $pdf = $preview->makepdf($student);
        $pdf->Output("Preview$student->id.pdf", 'I');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $adm_form = \App\AdmissionForm::with(['course', 'admSubs', 'AdmissionSubPreference', 'admSubs.subjectGroup', 'admSubs.subject'])->findOrFail($id);
        if (Gate::denies('student-adm-form', $adm_form)) {
            abort('401', 'Resource does not belong to current user!!');
        }
        if ($adm_form->final_submission == 'Y') {
            return redirect()->back()->with('message', 'You can not Edit Your Form After Final Submission');
        }
        $old_hon_sub = [];
        if ($adm_form->lastyr_rollno) {
            $student_data = \App\PrvStudent::where('roll_no', $adm_form->lastyr_rollno)->first();
            if ($student_data) {
                $old_hon_sub = $student_data->getOldHonSub();
            }
        }
        $course = $adm_form->course;
        $course_type = $course->status;
        $compSubs = $adm_form->course->getSubs('C');
        $optionalSubs = $adm_form->course->getSubs('O');
        $compGrps = $adm_form->course->getSubGroups('C');
        $optionalGrps = $adm_form->course->getSubGroups('O');
        $electives = $adm_form->course->getElectives();
        $alumani =  $adm_form->alumani;
        $hostel_data =  $adm_form->hostelData;
        $becholor_degree_details = $adm_form->becholorDegreeDetails;
        $selectedOpts = [];
        foreach ($adm_form->admSubs as $value) {
            if ($value->sub_group_id > 0 && $value->subjectGroup) {
                if ($value->subjectGroup->type == "C") {
                    foreach ($compGrps as $key => $val) {
                        if ($val['id'] == $value->sub_group_id) {
                            $compGrps[$key]['selectedid'] = $value->subject_id;
                        }
                    }
                } elseif ($value->ele_group_id > 0) {
                    foreach ($optionalGrps as $key => $val) {
                        if ($val['id'] == $value->sub_group_id) {
                            $optionalGrps[$key]['selectedid'] = $value->subject_id;
                        }
                    }
                }
            } else {
                if ($value->ele_group_id > 0 && $value->electiveGroup) {
                    foreach ($electives as $ele) {
                        if ($ele->id == $adm_form->selected_ele_id) {
                            foreach ($ele->groups as $grp) {
                                foreach ($grp->details as $detail) {
                                    if ($detail->subject_id == $value->subject_id) {
                                        $grp->selectedid = $value->subject_id;
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $selectedOpts[] = $value->subject_id;
                }
            }
        }
        $honoursSubjects = $course->getHonours();
        $preferences = $adm_form->honours->pluck('preference', 'subject_id');
        // dd($preferences);
        foreach ($honoursSubjects as $honSub) {
            $honSub['opted'] = isset($preferences[$honSub->subject_id]) ? true : false;
            $honSub['selected'] = false;
            $honSub['preference'] = isset($preferences[$honSub->subject_id]) ? $preferences[$honSub->subject_id] : 0;
        }
        // dd($honoursSubjects);
        // dd($adm_form);
        $data = compact('adm_form', 'compSubs', 'optionalSubs', 'compGrps', 'optionalGrps', 'electives', 'selectedOpts', 'honoursSubjects', 'course_type', 'alumani', 'hostel_data', 'becholor_degree_details', 'old_hon_sub');
        return view('admissionform.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdmissionFormRequest $request, $id)
    {
        $adm_form = \App\AdmissionForm::findOrFail($id);
        if (Gate::denies('student-adm-form', $adm_form)) {
            return response()->json(['resource' => ['Resource does not belong to the current user!!']], 422, ['Content-type' => 'application/json']);
        }
        //      abort('401', 'Resource does not belong to current user!!');
        $request->save();
        return $request->redirect();
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

    public function printDetail($id)
    {
        //
        $student = \App\AdmissionForm::findOrFail($id);
        return view('admissionform.admprint', compact('students', 'student'));
    }

    public function details($id)
    {
        $adm_form = \App\AdmissionForm::findOrFail($id);
        // dd($adm_form);
        // dd($adm_form->reservedHostel());
        $adm_form->load(['student','hostel_form','consent','discrepancy','course','admEntry.honour_sub','admEntry.add_on_course']);
        if (Gate::denies('student-adm-form', $adm_form)) {
            abort('401', 'Resource does not belong to current user!!');
        }
        $discrepancy_remarks = '';
        // dd($adm_form->discrepancy);
        if($adm_form->discrepancy){
            foreach($adm_form->discrepancy as $dis){
                $discrepancy_remarks = $dis->remarks;
            }
        }
        // dd($adm_form->student_id);
        // $subIds = \App\StudentSubs::where('student_id','=',$adm_form->std_id)->pluck('subject_id')->toArray();
        // $student_sub = \App\Subject::where('id','=',$subIds)->pluck('subject')->toArray();
        $student_sub = \App\StudentSubs::join(getSharedDb() .'subjects','subjects.id','=','student_subs.subject_id')
                                        ->where('student_subs.student_id','=',$adm_form->std_id)
                                        ->select([
                                            'subjects.subject','subjects.id',
                                        ])->get();

        $course_sub = \App\CourseSubject::join(getSharedDb() .'subjects','subjects.id','=','course_subject.subject_id')
                        ->where('course_subject.course_id','=',$adm_form->course_id)
                        ->where('course_subject.sub_type','=','C')
                        ->select([
                            'subjects.subject','subjects.id',
                        ])->get();
        return view('admissionform.student_detail', compact('adm_form','discrepancy_remarks','course_sub','student_sub'));
    }

    public function getStudentDetails($roll_no)
    {
        $student_data = \App\PrvStudent::where('roll_no', $roll_no)->first();
        if ($student_data) {
            return response()->json([
                'data' => $student_data,
                'old_subjects' => $student_data->getOldSubs(),
                'next_course_id' => Course::nextCourseId($student_data->course_id),
                'old_hon_sub' => $student_data->getOldHonSub(),
                'success' => true
            ]);
        }
        return response()->json([
            'success' => false
        ]);
    }

    public function leaveApplication($id)
    {
        $student = \App\AdmissionForm::findOrFail($id);
        $student = $student->load('student', 'student.course');
        // dd($student);
        $preview = new \App\Printings\LeaveApplicationPrint();
        $pdf = $preview->makepdf($student);
        $pdf->Output("Preview $student->id .pdf", 'I');
    }

    public function noDuesSlip($id)
    {
        $student = \App\AdmissionForm::findOrFail($id);
        if (Gate::denies('student-adm-form', $student)) {
            abort('401', 'Resource does not belong to current user!!');
        }
        $studentuser = StudentUser::where('id', auth('students')->user()->id)->first();
        if ($studentuser->mobile_verified == 'Y' && $studentuser->email2_confirmed == 'Y') {
            $student = $student->load('student', 'student.course', 'admEntry.admForm.attachments');
            $preview = new \App\Printings\NoDuesSlipPrint();
            $pdf = $preview->makepdf($student);
            $pdf->Output("Preview $student->id .pdf", 'I');
        } else {
            return redirect()->back()->with('message', 'Mobile or Email Verification is pending.');
            // flash()->success('Mobile or Email Verification is pending.');
        }
    }

    public function printSlip()
    {
        $std_user = auth('students')->user();
        $adm_form = $std_user->adm_form;
        $adm_entry = $adm_form->admEntry;
        $slip = new \App\Printings\AdmEntrySlip();
        $pdf = $slip->makepdf($adm_entry);
        $pdf->Output("Slip$adm_entry->id.pdf", 'I');
    }
}
