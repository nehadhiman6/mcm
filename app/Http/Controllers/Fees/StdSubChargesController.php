<?php

namespace App\Http\Controllers\fees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\SubFeeHead;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\FeeBill;
use Gate;

class StdSubChargesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('STUDENT-SUBJECT-CHARGES')){
            return deny();
        }
//        $student = Student::find(5919);
//        dd($student->stdSubsCharges());
        return view('fees.stdsubcharges.index');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'student_id' => 'required|exists:'.getYearlyDbConn().'.students,id'
        ]);
        $std_id = $request->student_id;
        $bill_amt = 0;
        $amt_rec = 0;
        $fee_amt = 0;
        $concession = 0;
        $index_no = 1;
        $feebilldets = new \Illuminate\Database\Eloquent\Collection();
        $student = Student::find($std_id);
        $subdets = $student->stdSubsUnCharged()->get();
        if ($subdets->count() > 0) {
            foreach ($subdets as $subdet) {
                if (floatval($subdet['pract_fee']) != 0) {
                    $subhead = SubFeeHead::find($subdet['pract_id']);
                    // $feebilldet = new \App\FeeBillDet();
                    $feebilldet = FeeBill::join('fee_bill_dets', 'fee_bill_dets.fee_bill_id', '=', 'fee_bills.id')
                        ->where('fee_bills.std_id', '=', $std_id)
                        ->where('fee_bill_dets.subject_id', '=', $subdet['subject_id'])
                        ->where('fee_bill_dets.subhead_id', '=', $subdet['pract_id'])
                        ->select('fee_bills.*')->get()->first();
                    if (!$feebilldet) {
                        $feebilldet = new \App\FeeBillDet();
                        $feebilldet->fill(['feehead_id' => $subhead->feehead_id, 'subhead_id' => $subdet['pract_id'], 'amount' => $subdet['pract_fee'],
                            'concession' => 0, 'index_no' => $index_no, 'sub_type' => 'Practical','subject_id' => $subdet['subject_id']]);
                        $feebilldets->add($feebilldet);
                        $fee_amt += floatval($subdet['pract_fee']);
                        $index_no++;
                    }
                }
                if (floatval($subdet['hon_fee']) != 0) {
                    $subhead = SubFeeHead::find($subdet['hon_id']);
                    // $feebilldet = new \App\FeeBillDet();
                    $feebilldet = FeeBill::join('fee_bill_dets', 'fee_bill_dets.fee_bill_id', '=', 'fee_bills.id')
                        ->where('fee_bills.std_id', '=', $std_id)
                        ->where('fee_bill_dets.subject_id', '=', $subdet['subject_id'])
                        ->where('fee_bill_dets.subhead_id', '=', $subdet['hon_id'])
                        ->select('fee_bills.*')->get()->first();
                    if (!$feebilldet) {
                        $feebilldet = new \App\FeeBillDet();
                        $feebilldet->fill(['feehead_id' => $subhead->feehead_id, 'subhead_id' => $subdet['hon_id'], 'amount' => $subdet['hon_fee'],
                            'concession' => 0, 'index_no' => $index_no, 'sub_type' => 'Honours','subject_id' => $subdet['subject_id']]);
                        $feebilldets->add($feebilldet);
                        $fee_amt += floatval($subdet['hon_fee']);
                        $index_no++;
                    }
                    // dd($feebilldet);
                }
                if (floatval($subdet['pract_exam_fee']) != 0) {
                    $feebilldet = new \App\FeeBillDet();
                    $subhead = SubFeeHead::find($subdet['exam_id']);
                    $feebilldet->fill(['feehead_id' => $subhead->feehead_id, 'subhead_id' => $subdet['exam_id'], 'amount' => $subdet['pract_exam_fee'],
                    'concession' => 0, 'index_no' => $index_no, 'sub_type' => 'Pract_exam','subject_id' => $subdet['subject_id']]);
                    $feebilldets->add($feebilldet);
                    $fee_amt += floatval($subdet['pract_exam_fee']);
                    $index_no++;
                }
                if (floatval($subdet['hon_exam_fee']) != 0) {
                    $feebilldet = new \App\FeeBillDet();
                    $subhead = SubFeeHead::find($subdet['exam_id']);
                    $feebilldet->fill(['feehead_id' => $subhead->feehead_id, 'subhead_id' => $subdet['exam_id'], 'amount' => $subdet['hon_exam_fee'],
                    'concession' => 0, 'index_no' => $index_no, 'sub_type' => 'Honours','subject_id' => $subdet['subject_id']]);
                    $feebilldets->add($feebilldet);
                    $fee_amt += floatval($subdet['hon_exam_fee']);
                    $index_no++;
                }
            }
        }
        $subdets = $student->stdHonsUnCharged()->get();
        // dd($subdets);
        if ($subdets->count() > 0) {
            foreach ($subdets as $subdet) {
                if (floatval($subdet['hon_fee']) != 0) {
                    $subhead = SubFeeHead::find($subdet['hon_id']);
                    $feebilldet = FeeBill::join('fee_bill_dets', 'fee_bill_dets.fee_bill_id', '=', 'fee_bills.id')
                        ->where('fee_bills.std_id', '=', $std_id)
                        ->where('fee_bill_dets.subject_id', '=', $subdet['subject_id'])
                        ->where('fee_bill_dets.subhead_id', '=', $subdet['hon_id'])
                        ->select('fee_bills.*')->get()->first();
                    if (! $feebilldet) {
                        $feebilldet = new \App\FeeBillDet();
                        $feebilldet->fill(['feehead_id' => $subhead->feehead_id, 'subhead_id' => $subdet['hon_id'], 'amount' => $subdet['hon_fee'],
                            'concession' => 0, 'index_no' => $index_no, 'sub_type' => 'Honours','subject_id' => $subdet['subject_id']]);
                        $feebilldets->add($feebilldet);
                        $fee_amt += floatval($subdet['hon_fee']);
                        $index_no++;
                    }
                }
                if (floatval($subdet['hon_exam_fee']) != 0) {
                    $feebilldet = new \App\FeeBillDet();
                    $subhead = SubFeeHead::find($subdet['exam_id']);
                    $feebilldet->fill(['feehead_id' => $subhead->feehead_id, 'subhead_id' => $subdet['exam_id'], 'amount' => $subdet['hon_exam_fee'],
                    'concession' => 0, 'index_no' => $index_no, 'sub_type' => 'Honours','subject_id' => $subdet['subject_id']]);
                    $feebilldets->add($feebilldet);
                    $fee_amt += floatval($subdet['hon_exam_fee']);
                    $index_no++;
                }
            }
        }
        $bill_amt += $fee_amt;
        if ($feebilldets->count() > 0) {
            try {
                DB::connection(getYearlyDbConn())->beginTransaction();
                $feebill = new \App\FeeBill();
                $feebill->fill(['course_id' => $student->course_id, 'std_type_id' => $student->std_type_id,
                    'bill_date' => Carbon::now()->format('d-m-Y'),'install_id' => 0,
                    'concession_id' => 0,
                    'fee_type' => 'Subject Charges','fund_type'=>'C', 'fee_amt' => $fee_amt, 'bill_amt' => $bill_amt,
                    'amt_rec' => 0, 'concession' => 0, 'remarks' => ''
                ]);
                $feebill->std_id = $student->id;
                $feebill->save();
                $feebill->feeBillDets()->saveMany($feebilldets);
                DB::connection(getYearlyDbConn())->commit();
            } catch (\Exception $ex) {
                $this->errors = new \Illuminate\Support\MessageBag();
                $this->errors->add('rollno', $ex->getMessage());
            }
        }
        // $student->load('stdSubsCharged.subject', 'stdHonsCharged');
        $student->load('stdSubsCharges.subject', 'stdSubsCharged.subject', 'stdHonsCharges', 'stdHonsCharged');
        return reply('OK', compact('student'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $students = Student::whereCourseId($id)->get();
        $students->load('stdSubsCharges.subject', 'stdSubsCharged.subject', 'stdHonsCharges', 'stdHonsCharged');
        return $students;
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

    public function addCharges($std_id, $course_id)
    {
        $bill_amt = 0;
        $amt_rec = 0;
        $fee_amt = 0;
        $concession = 0;
        $index_no = 1;
        $feebilldets = new \Illuminate\Database\Eloquent\Collection();
        $student = Student::find($std_id);
        $subdets = $student->stdSubsUnCharged()->get();
        if ($subdets->count() > 0) {
            foreach ($subdets as $subdet) {
                if (floatval($subdet['pract_fee']) != 0) {
                    $feebilldet = new \App\FeeBillDet();
                    $subhead = SubFeeHead::find($subdet['pract_id']);
                    $feebilldet->fill(['feehead_id' => $subhead->feehead_id, 'subhead_id' => $subdet['pract_id'], 'amount' => $subdet['pract_fee'],
                    'concession' => 0, 'index_no' => $index_no, 'sub_type' => 'Practical','subject_id' => $subdet['subject_id']]);
                    $feebilldets->add($feebilldet);
                    $fee_amt += floatval($subdet['pract_fee']);
                    $index_no++;
                }
                if (floatval($subdet['hon_fee']) != 0) {
                    $feebilldet = new \App\FeeBillDet();
                    $subhead = SubFeeHead::find($subdet['hon_id']);
                    $feebilldet->fill(['feehead_id' => $subhead->feehead_id, 'subhead_id' => $subdet['hon_id'], 'amount' => $subdet['hon_fee'],
                    'concession' => 0, 'index_no' => $index_no, 'sub_type' => 'Honours','subject_id' => $subdet['subject_id']]);
                    $feebilldets->add($feebilldet);
                    $fee_amt += floatval($subdet['hon_fee']);
                    $index_no++;
                }
                if (floatval($subdet['pract_exam_fee']) != 0) {
                    $feebilldet = new \App\FeeBillDet();
                    $subhead = SubFeeHead::find($subdet['exam_id']);
                    $feebilldet->fill(['feehead_id' => $subhead->feehead_id, 'subhead_id' => $subdet['exam_id'], 'amount' => $subdet['pract_exam_fee'],
                    'concession' => 0, 'index_no' => $index_no, 'sub_type' => 'Pract_exam','subject_id' => $subdet['subject_id']]);
                    $feebilldets->add($feebilldet);
                    $fee_amt += floatval($subdet['pract_exam_fee']);
                    $index_no++;
                }
                if (floatval($subdet['hon_exam_fee']) != 0) {
                    $feebilldet = new \App\FeeBillDet();
                    $subhead = SubFeeHead::find($subdet['exam_id']);
                    $feebilldet->fill(['feehead_id' => $subhead->feehead_id, 'subhead_id' => $subdet['exam_id'], 'amount' => $subdet['hon_exam_fee'],
                    'concession' => 0, 'index_no' => $index_no, 'sub_type' => 'Honours','subject_id' => $subdet['subject_id']]);
                    $feebilldets->add($feebilldet);
                    $fee_amt += floatval($subdet['hon_exam_fee']);
                    $index_no++;
                }
            }
            $bill_amt += $fee_amt;
            try {
                DB::connection(getYearlyDbConn())->beginTransaction();
                $feebill = new \App\FeeBill();
                $feebill->fill(['course_id' => $student->course_id, 'std_type_id' => $student->std_type_id,
                    'bill_date' => Carbon::now()->format('d-m-Y'),'install_id' => 0,
                    'concession_id' => 0,
                    'fee_type' => 'Subject Charges','fund_type'=>'C', 'fee_amt' => $fee_amt, 'bill_amt' => $bill_amt,
                    'amt_rec' => 0, 'concession' => 0, 'remarks' => ''
                ]);
                $feebill->std_id = $student->id;
                $feebill->save();
                $feebill->feeBillDets()->saveMany($feebilldets);
                DB::connection(getYearlyDbConn())->commit();
            } catch (\Exception $ex) {
                $this->errors = new \Illuminate\Support\MessageBag();
                $this->errors->add('rollno', $ex->getMessage());
            }
        }
    }
}
