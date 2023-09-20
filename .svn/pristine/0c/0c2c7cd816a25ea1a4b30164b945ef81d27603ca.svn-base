<?php

namespace App\Http\Controllers\Admissions;

use App\Course;
use App\FeeStructure;
use Illuminate\Http\Request;
use \App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\Payment;
use App\SubFeeHead;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('NEW-ADMISSION')) {
            return deny();
        }
        return view('admissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd(url('/'));
        if (Gate::denies('NEW-ADMISSION')) {
            return deny();
        }

        if (!request()->ajax()) {
            return View('admissions.create');
        }
        $messages = [];
        $student_det = \App\AdmissionForm::where('id', '=', $request->form_no)
            ->with('course')->first();
        if ($student_det) {
            $rules = ['form_no' => 'required|exists:' . getYearlyDbConn() . '.admission_entries,admission_id'];
            $messages = ['form_no.exists' => 'No Admission Entry Found For This Form No.Update Admission Entry Before Admission.'];
        } else {
            $rules = ['form_no' => 'required|exists:' . getYearlyDbConn() . '.admission_forms,id'];
        }

   
        if ($student_det && $adm_entry = $student_det->admEntry) {
            // if (Carbon::today()->diffInDays(Carbon::createFromFormat('d-m-Y', $adm_entry->valid_till)->setTime(0, 0, 0)) > 0)
            //condition for vlidity till 12 PM (in the noon)
            if (Carbon::now()->diffInHours(Carbon::createFromFormat('d-m-Y H:i:s', $adm_entry->valid_till . " 23:59:00"), false) < 0) {
                //  if (Carbon::today()->diffInDays(Carbon::createFromFormat('d-m-Y', $adm_entry->valid_till)->setTime(0, 0, 0), false) < 0) {
                $rules['entry-date'] = 'required';
            }
            $messages += [
                'entry-date.required' => 'Admission Entry was valid till ' . $adm_entry->valid_till . " mid night",
            ];
        }
        //dd($adm_entry->std_type_id);
        if ($student_det && $student_det->status == 'A') {
            $rules['adm_no'] = 'required';
            $messages += [
                'adm_no.required' => 'Student is already admitted!!'
            ];
        }

        //    dd($rules);
        $this->validate($request, $rules, $messages);

        

        $fee_str = FeeStructure::join('sub_heads', 'sub_heads.id', '=', 'fee_structures.subhead_id')
            ->join('fee_heads', 'fee_heads.id', '=', 'sub_heads.feehead_id')
            ->orderBy('fee_heads.name')
            ->whereCourseId($student_det->course_id)
            ->whereStdTypeId($adm_entry->std_type_id)->whereInstallmentId(1)
            ->with('subhead', 'subhead.feehead')
            ->select('fee_structures.*', 'sub_heads.feehead_id', DB::raw("fee_structures.opt_default as charge, fee_structures.subhead_id, fee_structures.amount as amt_rec, 0 as concession"));
        if($student_det->mcm_graduate == 'Y') {
            $course = Course::find($student_det->course_id);
            if(strtoupper($course->status) == 'PGRAD' && $course->final_year == 'Y') {
                $fee_str = $fee_str->where('sub_heads.id','<>',223);
            }
        }
        $fee_str = $fee_str->get();
        $misc_charges = $student_det->getMiscCharges();
        $other_charges = $student_det->getOtherCharges();
        $exam_fee = 0;
        $exam_type = '';
        foreach ($misc_charges as $misc) {
            if(floatval($misc->hon_exam_fee) > $exam_fee) {
                $exam_fee = floatval($misc->hon_exam_fee);
                $exam_type = 'H';
            }
            if(floatval($misc->pract_exam_fee) > $exam_fee) {
                $exam_fee = floatval($misc->pract_exam_fee);
                $exam_type = 'P';
            }
        }
        foreach ($misc_charges as $misc) {
            if(floatval($misc->hon_exam_fee) != 0 && $exam_type == 'P') {
                $misc->hon_exam_fee = 0;
            }
            if(floatval($misc->pract_exam_fee) != 0 && $exam_type == 'H') {
                $misc->pract_exam_fee = 0;
            }
        }

        $fee_str_tmp = clone $fee_str->first();
        unset($fee_str_tmp->subhead);
        $fee_str_tmp->charge = 'Y';
        $fee_str_tmp->optional = 'N';
        foreach($misc_charges as $det) {
            $fee_str = $this->getFeeStr($fee_str,$fee_str_tmp,$det->hon_id,$det->hon_fee,$det->course_id,'HONOURS FEE('.$det->subject.')');
            $fee_str = $this->getFeeStr($fee_str,$fee_str_tmp,$det->hon_id,$det->hon_exam_fee,$det->course_id,'HONOURS EXAM FEE');
            $fee_str = $this->getFeeStr($fee_str,$fee_str_tmp,$det->pract_id,$det->pract_exam_fee,$det->course_id,'PRACTICAL EXAM FEE');
            $fee_str = $this->getFeeStr($fee_str,$fee_str_tmp,$det->pract_id,$det->pract_fee,$det->course_id,'PRACTICAL FEE('.$det->subject.')');
        }
        foreach($other_charges as $det) {
            $fee_str = $this->getFeeStr($fee_str,$fee_str_tmp,$det['sh_id'],$det['charges'],$student_det->course_id,$det['name']);
        }

        // $fee_str = \App\FeeStructure::join('sub_heads', 'sub_heads.id', '=', 'fee_structures.subhead_id')
        //   ->orderBy('sub_heads.feehead_id')->orderBy('sub_heads.name')
        //   ->whereCourseId($student_det->course_id)
        //   ->whereStdTypeId($adm_entry->std_type_id)->whereInstallmentId(1)
        //   ->with('subhead', 'subhead.feehead')
        //   ->select('fee_structures.*', 'sub_heads.feehead_id', DB::raw("fee_structures.opt_default as charge, fee_structures.subhead_id, fee_structures.amount as amt_rec, 0 as concession"))
        //   ->get();

        // $fee_str = $fee_str->groupBy('feehead_id');
        $fee_str = $fee_str->groupBy(function ($item, $key) {
            return $item['subhead']['feehead']['name'];
            // return $item['subhead_id'] . '_' . $item['course_id'];
        });
        
        $con_feeheads = \App\FeeHead::where('concession', '=', 'N')->pluck('name');
        return compact('student_det', 'fee_str', 'adm_entry', 'con_feeheads','misc_charges','other_charges') + ['installment_id' => 1];
        // return view('admissions.create', compact('student_det', 'fee_str'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\AdmissionRequest $request)
    {
        if (Gate::denies('NEW-ADMISSION')) {
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

    private function getFeeStr($fee_str,$fee_str_tmp,$subhead_id,$amount,$course_id,$name) {
        if(intval($subhead_id) > 0) {
            $fee_str_tmp1 = clone $fee_str_tmp;
            $subhead = SubFeeHead::find($subhead_id);
            $subhead->load('feehead');
            $subhead->feehead->name = $name;
            if(intval($amount) > 0) {
                $fee_str_tmp1->amount = $amount;
                $fee_str_tmp1->amt_rec = $amount;
                $fee_str_tmp1->course_id = $course_id;
                $fee_str_tmp1->subhead_id = $subhead->id;
                $fee_str_tmp1->feehead_id = $subhead->feehead_id;
                $fee_str_tmp1->subhead = $subhead;
                $fee_str[] = $fee_str_tmp1;
            }
        }
        return $fee_str;
    }
}
