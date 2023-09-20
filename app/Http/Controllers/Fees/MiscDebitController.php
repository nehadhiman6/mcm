<?php

namespace App\Http\Controllers\Fees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\SubFeeHead;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Gate;

class MiscDebitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('MISCELLANEOUS-DEBIT')){
            return deny();
        }
        return view('fees.miscdebits.index');
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
        $this->validate($request, [
            'course_id' => 'required|exists:' . getYearlyDbConn() . '.courses,id',
            'subhead_id' => 'required|exists:' . getYearlyDbConn() . '.sub_heads,id',
            ]);
        $subhead_id = $request->subhead_id;
        $course_id = $request->course_id;
        $subhead = SubFeeHead::find($subhead_id);
        $subhead->load('feehead');
        $students = $request->students;
        //  return $students;
        foreach ($students as $student) {
            if (floatval($student['charges']) > 0) {
                $std_id = $student['std_id'];
                $bill_amt = 0;
                $fee_amt = 0;
                $concession = 0;
                $index_no = 1;
                $feebilldet = new \App\FeeBillDet();
                $feebilldet->fill(['feehead_id' => $subhead->feehead_id, 'subhead_id' => $subhead_id, 'amount' => $student['charges'],
                    'concession' => 0, 'index_no' => $index_no]);
                $fee_amt = $student['charges'];
                $bill_amt = $student['charges'];
                try {
                    DB::connection(getYearlyDbConn())->beginTransaction();
                    $feebill = new \App\FeeBill();
                    $feebill->fill(['course_id' => $course_id, 'std_type_id' => $student['std_type_id'],
                        'bill_date' => Carbon::now()->format('d-m-Y'),'install_id' => 0,
                        'concession_id' => 0,
                        'fee_type' => 'Misc Charges','fund_type'=>'C', 'fee_amt' => $fee_amt, 'bill_amt' => $bill_amt,
                        'amt_rec' => 0, 'concession' => 0, 'remarks' => ''
                    ]);
                    $feebill->std_id = $student['std_id'];
                    $feebill->save();
                    $feebill->feeBillDets()->save($feebilldet);
                    DB::connection(getYearlyDbConn())->commit();
                } catch (\Exception $ex) {
                    $this->errors = new \Illuminate\Support\MessageBag();
                    $this->errors->add('rollno', $ex->getMessage());
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $students =  Student::orderBy(DB::raw('cast(roll_no as signed)'))
            ->where('course_id', '=', $id)
            ->get();
        return $students;
    }

    public function collegePending($id)
    {
        return Student::havingPendBal([
            'institution' => 'sggs',
            'fund_type' => 'C',
            'course_id' => $id,
        ]);

        $fee_rcpt_dets = \App\FeeRcptDet::join('fee_bill_dets', 'fee_rcpt_dets.fee_bill_dets_id', '=', 'fee_bill_dets.id')
            ->join('fee_rcpts', 'fee_rcpt_dets.fee_rcpt_id', '=', 'fee_rcpts.id')
            ->where('fee_rcpts.cancelled', '=', 'N')
            ->groupBy('fee_bill_dets.fee_bill_id')
            ->select('fee_bill_dets.fee_bill_id', DB::raw('sum(fee_rcpt_dets.amount) as amount'));

        $fee_bills = \App\FeeBill::leftJoin(DB::raw("({$fee_rcpt_dets->toSql()}) as receipts"), 'fee_bills.id', '=', 'receipts.fee_bill_id')
            ->mergeBindings($fee_rcpt_dets->getQuery())
            ->where('fee_bills.cancelled', '=', 'N');

        $fee_bills = $fee_bills->groupBy('fee_bills.std_id')
            ->select('fee_bills.std_id', DB::raw('sum(fee_bills.bill_amt)-sum(ifnull(receipts.amount,0)) as bal_amt'));
        $fee_bills = $fee_bills->where('fee_bills.fund_type', '=', 'C');
        $students = \App\Student::join(DB::raw("({$fee_bills->toSql()}) as fee_bills"), 'students.id', '=', 'fee_bills.std_id')
            ->mergeBindings($fee_bills->getQuery())
            ->where('fee_bills.bal_amt', '!=', 0);
        $students = $students->where('students.course_id', '=', $id)->where('adm_cancelled', '=', 'N')->where('removed', '=', 'N');
        
        $students =  $students->select('students.*')->orderBy(DB::raw('cast(students.roll_no as signed)'))->get();
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
}
