<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\AdmissionFormRequest;
use Illuminate\Support\Facades\Gate;
use App\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdmissionFormController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Gate::denies('ADMISSION-FORMS')) {
            return deny();
        }

        if (!request()->ajax()) {
            return view('admissionform.index');
        }
        ini_set('memory_limit', '1024M');

        $adm_forms = \App\AdmissionForm::orderBy('admission_forms.submission_time')
            ->between($request->date_from, $request->date_to)->orderBy('admission_forms.name');

        if ($request->course_id > 0) {
            $adm_forms = $adm_forms->where('admission_forms.course_id', '=', $request->course_id);
        }

        //we will show forms finally submitted only, unless requested
        if ($request->filled_by != 'to_be_submitted') {
            $adm_forms = $adm_forms->where('admission_forms.final_submission', '=', 'Y');
        }

        if ($request->filled_by != '') {
            if ($request->filled_by == 'students') {
                $adm_forms = $adm_forms->where('admission_forms.created_by', '=', 0);
            } elseif ($request->filled_by == 'officials') {
                $adm_forms = $adm_forms->where('admission_forms.created_by', '!=', 0);
            } elseif ($request->filled_by == 'to_be_submitted') {
                $adm_forms = $adm_forms->where('admission_forms.final_submission', '!=', 'Y');
            }
        }

        if ($request->status != '') {
            $adm_forms = $adm_forms->where('admission_forms.status', '=', $request->status);
        }

        if ($request->form_status != 'A') {
            if($request->form_status == 'SA'){
                $adm_forms = $adm_forms->whereIn('admission_forms.scrutinized',['Y','H']);
            }
            else{
                $adm_forms = $adm_forms->where('admission_forms.scrutinized', '=', $request->form_status);
            }
        }

        if ($request->hostel_only == 'Y') {
            $adm_forms = $adm_forms->join('payments', 'payments.std_user_id', '=', 'admission_forms.std_user_id')
                ->where('trn_type', '=', 'prospectus_fee_hostel')->where('payments.ourstatus', '=', 'OK');
        }
        $adm_forms = $adm_forms->select('admission_forms.*')->get();
        return $adm_forms->load([
            'course' => function ($q) {
                $q->select('id', 'course_name');
            },
            'attachments' => function ($q) {
                $q->select('id', 'admission_id', 'file_type');
            },
            'academics' => function ($q) {
                $q->select('id', 'admission_id', 'last_exam', 'exam', 'total_marks', 'marks_obtained', 'other_exam', 'institute', 'board_id', 'other_board', 'rollno', 'year', 'result', 'marks', 'marks_per', 'subjects','cgpa')
                    ->where('last_exam', '=', 'Y')
                    ->with('board');
            },
            'AdmissionSubPreference.subject','addOnCourse','honours.subject','hostel_form', 'admSubs.subject','category','res_category','discrepancy','std_user','sub_combinations.sub_comb.details.subject'
        ]);
        //  return view('admissionform.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //    dd(\App\Course::get(['id', 'course_name', 'status']));
        //    dd(\App\Course::get(['id', 'course_name', 'status'])->toJson());
        if (Gate::denies('NEW-ADMISSION-FORMS')) {
            return deny();
        }
        return view('admissionform.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdmissionFormRequest $request)
    {
        if (Gate::denies('NEW-ADMISSION-FORMS')) {
            return deny();
        }
        $request->save();
        //    if (auth()->user()->isStudent == 'Y') {
        //      return response()->json([
        //          'success' => "You Have Registered Succesfully Go To Your Profile to View Details",
        //           ], 200, ['app-status' => 'success']);
        //    }
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
        if (Gate::denies('PREVIEW-ADMISSION-FORMS')) {
            return deny();
        }
        $student = \App\AdmissionForm::findOrFail($id);
        //$comp_subjects = $student->course->subjects;
        $preview = new \App\Printings\AdmFormPrintPdf();
        $pdf = $preview->makepdf($student);
        $pdf->Output("Preview$student->id.pdf", 'I');
        // return view('admissionform.preview_detail', compact('student', 'comp_subjects'));
    }

    public function showHostel($id)
    {
        $student = \App\AdmissionForm::findOrFail($id);
        //$comp_subjects = $student->course->subjects;
        if (Gate::denies('PREVIEW-ADMISSION-FORMS')) {
            return deny();
        }
        // $student = $student->load('academics');
        $preview = new \App\Printings\HostelForm();
        $pdf = $preview->makepdf($student);
        $pdf->Output("Preview$student->id.pdf", 'I');
    }

    public function showPdf($id)
    {
        if (Gate::denies('PREVIEW-ADMISSION-FORMS')) {
            return deny();
        }
        $student = \App\AdmissionForm::findOrFail($id);
        //$comp_subjects = $student->course->subjects;
        $preview = new \App\Printings\AdmformPrint();
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
        if (Gate::denies('EDIT-ADMISSION-FORMS')) {
            return deny();
        }
        //
        $adm_form = \App\AdmissionForm::with(['course', 'admSubs', 'admSubs.subjectGroup', 'admSubs.subject'])->findOrFail($id);
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
        foreach ($honoursSubjects as $honSub) {
            $honSub['opted'] = isset($preferences[$honSub->subject_id]) ? true : false;
            $honSub['selected'] = false;
            $honSub['preference'] = isset($preferences[$honSub->subject_id]) ? $preferences[$honSub->subject_id] : 0;
        }
        // dd($honoursSubjects);
        // dd($adm_form);
        $data = compact('adm_form', 'compSubs', 'optionalSubs', 'compGrps', 'optionalGrps', 'electives', 'selectedOpts', 'honoursSubjects', 'course_type', 'alumani', 'hostel_data', 'becholor_degree_details', 'old_hon_sub');

        // $data = compact('adm_form', 'compSubs', 'optionalSubs', 'compGrps', 'optionalGrps', 'selectedOpts', 'course_type');
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
        if (Gate::denies('EDIT-ADMISSION-FORMS')) {
            return deny();
        }

        //        dd($request->all());
        //        dd($request->admissionSubs());
        $request->save();
        return $request->redirect();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOpenSubmission($id)
    {
        $student = \App\AdmissionForm::findOrFail($id);
        return view('admissionform.open_addmission', compact('student'));
    }

    public function openStudentAddmissionForm(Request $request)
    {
        if (Gate::denies('open-final-submission')) {
            return deny();
        }
        $student = \App\AdmissionForm::findOrFail($request->form_id);
        if ($student->admEntry || $student->consent) {
            $msg = ($student->admEntry ? "Admission Entry" : "Subjects consent") . " is there for this student!!";
            flash()->warning($msg);
            return redirect()->back();
        }
        $student->final_submission = 'N';
        $student->save();
        
        return redirect()->back();
    }

    public function printDetail($id)
    {
        if (Gate::denies('ADMISSION-FORMS')) {
            return deny();
        }
        $student = \App\AdmissionForm::findOrFail($id);
        $students = \App\AdmissionForm::all();
        return view('admissionform.admprint', compact('students', 'student'));
    }

    public function details($id)
    {
        if (Gate::denies('ADMISSION-FORMS')) {
            return deny();
        }
        $adm_form = \App\AdmissionForm::findOrFail($id);
        return view('admissionform.student_detail', compact('adm_form'));
    }

    public function paymentReport(Request $request)
    {
        if (Gate::denies('online-transactions')) {
            return deny();
        }

        if ($request->ajax()) {
            $admission_id =  $request->admission_id;
            $roll_no =  $request->roll_no;
            $date_by =  $request->date_by;

            $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
            $payments = [];

            $payments = Payment::leftJoin('admission_forms', 'payments.std_user_id', '=', 'admission_forms.std_user_id')
                ->leftJoin('students', 'payments.std_user_id', '=', 'students.std_user_id')
                ->select(['payments.*', 'admission_forms.name', DB::raw('admission_forms.id as admission_id'), DB::raw('admission_forms.lastyr_rollno as roll_no')]);

            if ($admission_id != '') {
                $payments = $payments->where('admission_forms.id', '=', $admission_id);
            } elseif ($roll_no != '') {
                $payments = $payments->where('students.roll_no', '=', $roll_no);
            } elseif ($date) {
                $payments = $payments->where('payments.created_at', '>=', Carbon::createFromFormat('d-m-Y', $request->date));
            }

            return $payments->get();
        }

        return view('admissionform.payment_report');
    }


    public function getOpenAttchmentSubmission($id)
    {
        $student = \App\AdmissionForm::findOrFail($id);
        return view('admissionform.attachment_submission', compact('student'));
    }

    public function openAttachmentAddmissionForm(Request $request)
    {
        if (Gate::denies('attachment-submission')) {
            return deny();
        }
        $student = \App\AdmissionForm::findOrFail($request->form_id);
        // if ($student->admEntry || $student->consent) {
        //     $msg = ($student->admEntry ? "Admission Entry" : "Subjects consent") . " is there for this student!!";
        //     flash()->warning($msg);
        //     return redirect()->back();
        // }
        
        $student->attachment_submission = 'N';
        $student->save();
        
        return redirect()->back();
    }

    public function getOpenScrutinized($id)
    {
        $student = \App\AdmissionForm::findOrFail($id);
        return view('admissionform.scrutinized', compact('student'));
    }

    public function openScrutinizedForm(Request $request)
    {
        if (Gate::denies('scrutinize-form')) {
            return deny();
        }
        // dd($request->all());
        $student = \App\AdmissionForm::findOrFail($request->form_id);
        // dd($student);
        if ($student->scrutinized == 'N') {
            $student->scrutinized = 'Y';
        } elseif ($student->scrutinized == 'Y') {
            $student->scrutinized = 'N';
        }
        $student->save();
        
        return view('admissionform.index');
    }

    public function getAllAttachment($adm_id){
        $student = \App\AdmissionForm::findOrFail($adm_id);
        $student->load([
            'attachments' => function ($q) {
                $q->select('id', 'admission_id', 'file_type','file_ext');
            },
            'course'
        ]);

        return view('admissionform.all_attachment_show', compact('student'));
    }

    public function getScrutinizedHostel($id,$type){
        if (Gate::denies('scrutinize-hostel')) {
            return deny();
        }
        // dd($id);
        $student = \App\AdmissionForm::findOrFail($id);
        $student->scrutinized = $type;
        $student->save();
        return reply('true',[
            'student' => $student
        ]);

    }
}
