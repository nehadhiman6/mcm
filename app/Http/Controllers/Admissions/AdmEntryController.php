<?php

namespace App\Http\Controllers\Admissions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdmEntryRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class AdmEntryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Gate::denies('ADMISSION-ENTRY')) {
            return deny();
        }
        if (!request()->ajax()) {
            return view('admentries.index');
        }
        $adm_entries = \App\AdmissionEntry::orderBy('id', 'desc')
            //        ->join('admission_forms', 'admission_forms.id', '=', 'admission_entries.admission_id')
            ->with([
                'admForm' => function ($q) {
                    $q->select('id', 'std_user_id', 'name', 'father_name', 'mobile', 'status', 'course_id', 'lastyr_rollno');
                },
                'admForm.course' => function ($q) {
                    $q->select('id', 'course_name');
                },
                'admForm.std_user' => function ($q) {
                    $q->select('id', 'email');
                },
            ]);

        $bal_column = '';

        if ($request->status != 'N') {
            $fee_rcpt_dets = \App\FeeRcptDet::join('fee_bill_dets', 'fee_rcpt_dets.fee_bill_dets_id', '=', 'fee_bill_dets.id')
                    ->join('fee_rcpts', 'fee_rcpt_dets.fee_rcpt_id', '=', 'fee_rcpts.id')
                    ->where('fee_rcpts.cancelled', '=', 'N')
                    ->groupBy('fee_bill_dets.fee_bill_id')
                    ->select('fee_bill_dets.fee_bill_id', DB::raw('sum(fee_rcpt_dets.amount+fee_rcpt_dets.concession) as amount'));
    
            $fee_bills = \App\FeeBill::leftJoin(DB::raw("({$fee_rcpt_dets->toSql()}) as receipts"), 'fee_bills.id', '=', 'receipts.fee_bill_id')
                    ->mergeBindings($fee_rcpt_dets->getQuery())
                    ->where('fee_bills.cancelled', '=', 'N');
    
            $fee_bills->groupBy('fee_bills.std_id')
                    ->select('fee_bills.std_id', DB::raw('sum(fee_bills.bill_amt)-sum(ifnull(receipts.amount,0)) as bal_amt'));
    
            $fee_bills = $fee_bills->where('fee_bills.fund_type', '=', 'C');
                
            $adm_entries = $adm_entries
                    ->leftJoin('students', function ($q) {
                        $q->on('students.admission_id', '=', 'admission_entries.admission_id')
                            ->where('students.adm_cancelled', '=', 'N')
                            ->where('students.removed', '=', 'N');
                    })
                    ->leftJoin(DB::raw("({$fee_bills->toSql()}) as fee_bills"), 'students.id', '=', 'fee_bills.std_id')
                    ->mergeBindings($fee_bills->getQuery());
    
            $adm_entries = $adm_entries->select('fee_bills.bal_amt');
        }


        $adm_entries = $adm_entries->where('admission_entries.created_at', '>=', mysqlDate($request->from_date));
        if ($request->upto_date == '') {
            $adm_entries = $adm_entries->where('admission_entries.created_at', '<=', mysqlDate($request->upto_date));
        }
        // if ($request->input('status', '') != '') {
        //     $adm_entries = $adm_entries->whereHas('admForm', function ($q) use ($request) {
        //         $q->where('status', '=', $request->status);
        //     });
        // }
        if (intval($request->input('course_id')) > 0 || $request->input('status', '') != '') {
            // $adm_entries = $adm_entries->whereHas('admForm', function ($q) use ($request) {
            //     $q->where('course_id', '=', $request->course_id);
            // });
            $adm_entries = $adm_entries->join('admission_forms', 'admission_forms.id', '=', 'admission_entries.admission_id');
            if (intval($request->input('course_id')) > 0) {
                $adm_entries = $adm_entries->where('admission_forms.course_id', '=', $request->course_id);
            }
            if ($request->input('status', '') != '') {
                $adm_entries = $adm_entries->where('admission_forms.status', '=', $request->status);
            }
        }
        
        return $adm_entries->addSelect('admission_entries.*')->get();
    }

    /**
     * Check Manual Form No Duplication
     *
     */
    public function checkManualFormno(Request $request)
    {
        //    dd($request->input('adm_entry.id'));
        if ($request->has('adm_entry.manual_formno')) {
            $rules['adm_entry.manual_formno'] = 'unique:' . getYearlyDbConn() . '.admission_entries,manual_formno,' . $request->input('adm_entry.id');
        }

        if ($request->has('adm_entry.adm_rec_no')) {
            $rules['adm_entry.adm_rec_no'] = 'unique:' . getYearlyDbConn() . '.admission_entries,adm_rec_no,null' . $request->input('adm_entry.id');
        }


        $this->validate($request, $rules);
        //    if () {
        //      return $msg = 'Manual Formno Already Exists';
        //    }
        //    if () {
        //      return $msg = 'Receipt no Already Exist For This Student';
        //    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (Gate::denies('NEW-ADMISSION-ENTRY')) {
            return deny();
        }
        if (!request()->ajax()) {
            return view('admentries.create');
        }
        //    var_dump($request->has('manual_formno'));
        //    var_dump($request->get('manual_formno','empty'));
        //    dd($request->has('adm_entry.manual_formno'));
        $messages = [];
        $rules = [];
        $student_det = \App\AdmissionForm::with(['course', 'admSubs', 'admSubs.subjectGroup', 'admSubs.subject', 'std_user', 'admEntry', 'category', 'res_category'])
            ->firstOrNew(['id' => $request->input('adm_entry.admission_id', 0)]);

        //if student is already admitted
        if ($student_det->status == 'A') {
            $rules += ['admitted' => 'required'];
        }
        $manual_form_no = false;
        if (($request->has('adm_entry.manual_formno') && intval($request->input('adm_entry.manual_formno')) > 0) || $student_det->admEntry) {
            $manual_form_no = true;
        }

        if ($manual_form_no == false && $student_det->exists && $student_det->final_submission == 'N' && $request->input('adm_entry.centralized') == 'N') {
            $rules += [
                'final_submission' => 'required'
            ];
        }

        if ($request->input('adm_entry.centralized') == 'N') {
            $rules += [
                'adm_entry.admission_id' => ($manual_form_no ? '' : 'required|numeric|min:1|') .
                                            (intval($request->input('adm_entry.admission_id')) > 0 ? 'exists:' . getYearlyDbConn() . '.admission_forms,id' : ''),
                'adm_entry.manual_formno' => ($request->has('adm_entry.admission_id') ? '' : 'required_without:adm_entry.admission_id|') . (intval($request->input('adm_entry.admission_id')) > 0 ? '' : 'required|') . 'nullable',
                'adm_entry.std_type_id' => 'required|numeric|min:1',
            ];
        }
        // $rules += [
        //     'adm_entry.centralized' => 'in:Y,N',
        //     'adm_entry.adm_rec_no' => 'required_if:adm_entry.centralized,Y',
        //     'adm_entry.rcpt_date' => 'required_if:adm_entry.centralized,Y',
        //     'adm_entry.amount' => 'required_if:adm_entry.centralized,Y',
        // ];
        $messages = [
            'admitted.required' => 'Student is already admitted.',
            'final_submission.required' => 'Online Admission form is not submitted by the student',
            'adm_entry.std_type_id.min' => 'Student Type is Required'
        ];
        $this->validate($request, $rules, $messages);
        //  if ($request->has('admission_id'))
        $form_loaded = false;

        $course = $student_det->course;
        if ($student_det->course) {
            $compSubs = $student_det->course->getSubs('C');
            $optionalSubs = $student_det->course->getSubs('O');
            $compGrps = $student_det->course->getSubGroups('C');
            $optionalGrps = $student_det->course->getSubGroups('O');
            $electives = $student_det->course->getElectives();
            $selectedOpts = [];
            // foreach ($student_det->admSubs as $value) {
            //     if ($value->sub_group_id == 0) {
            //         $selectedOpts[] = $value->subject_id;
            //     } else {
            //         if ($value->subjectGroup->type == "C") {
            //             foreach ($compGrps as $key => $val) {
            //                 if ($val['id'] == $value->sub_group_id) {
            //                     $compGrps[$key]['selectedid'] = $value->subject_id;
            //                 }
            //             }
            //         } else {
            //             foreach ($optionalGrps as $key => $val) {
            //                 if ($val['id'] == $value->sub_group_id) {
            //                     $optionalGrps[$key]['selectedid'] = $value->subject_id;
            //                 }
            //             }
            //         }
            //         //  $grps[$value->subjectGroup->type][$value->sub_group_id] = '';
            //     }
            // }
            foreach ($student_det->admSubs as $value) {
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
                            if ($ele->id == $student_det->selected_ele_id) {
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
        }
        $honoursSubjects = $course->getHonours();
        return reply('Validated!', compact('student_det', 'compSubs', 'optionalSubs', 'compGrps', 'optionalGrps', 'electives', 'selectedOpts', 'course', 'honoursSubjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdmEntryRequest $request)
    {
        if (Gate::denies('NEW-ADMISSION-ENTRY')) {
            return deny();
        }
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
        if (Gate::denies('NEW-ADMISSION-ENTRY')) {
            return deny();
        }
        $adm_entry = \App\AdmissionEntry::findOrFail($id);
        //  dd('here');
        return view('admentries.create', compact('adm_entry') + ['form_task' => 'edit']);

        $student_det = $adm_entry->admForm;
        $student_det->load(['std_user']);
        $std_type = $adm_entry->stdType;
        //  dd($std_type);
        $course = $student_det->course;
        if ($student_det->course) {
            $compSubs = $student_det->course->getSubs('C');
            $optionalSubs = $student_det->course->getSubs('O');
            $compGrps = $student_det->course->getSubGroups('C');
            $optionalGrps = $student_det->course->getSubGroups('O');
            $selectedOpts = [];
            foreach ($student_det->admSubs as $value) {
                if ($value->sub_group_id == 0) {
                    $selectedOpts[] = $value->subject_id;
                } else {
                    if ($value->subjectGroup->type == "C") {
                        foreach ($compGrps as $key => $val) {
                            if ($val['id'] == $value->sub_group_id) {
                                $compGrps[$key]['selectedid'] = $value->subject_id;
                            }
                        }
                    } else {
                        foreach ($optionalGrps as $key => $val) {
                            if ($val['id'] == $value->sub_group_id) {
                                $optionalGrps[$key]['selectedid'] = $value->subject_id;
                            }
                        }
                    }
                    //            $grps[$value->subjectGroup->type][$value->sub_group_id] = '';
                }
            }
        }
        return view('admentries.create', compact('student_det', 'std_type', 'adm_entry', 'compSubs', 'optionalSubs', 'compGrps', 'optionalGrps', 'selectedOpts', 'course') + ['form_task' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdmEntryRequest $request, $id)
    {
        if (Gate::denies('NEW-ADMISSION-ENTRY')) {
            return deny();
        }
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

    public function printSlip(Request $request, $id)
    {
        //
        $adm_entry = \App\AdmissionEntry::find($id);
        $slip = new \App\Printings\AdmEntrySlip();
        $pdf = $slip->makepdf($adm_entry);
        $pdf->Output("Slip$adm_entry->id.pdf", 'I');
    }

    public function editEmail($id)
    {
        if (Gate::denies('UPDATE-STDEMAIL')) {
            return deny();
        }
        $std_user = \App\StudentUser::find($id);
        return view('admentries.updt_email', compact('std_user'));
    }

    public function updateEmail(Request $request, $id)
    {
        if (Gate::denies('UPDATE-STDEMAIL')) {
            return deny();
        }
        // dd($request->all());
        $std_user = \App\StudentUser::find($id);
        $messages = [];
        $rules = [
            'email' => 'required|max:50|unique:' . getYearlyDbConn() . '.student_users,email,' . $id,
        ];
        $this->validate($request, $rules, $messages);
        $std_user->email = $request->email;
        $std_user->update();
        return redirect('adm-entries');
    }
}
