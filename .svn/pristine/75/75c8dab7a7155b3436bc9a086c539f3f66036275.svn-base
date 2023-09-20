<?php

namespace App\Http\Controllers\Fees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\SubFeeHead;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Gate;

class MiscDebitHostelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('MISCELLANEOUS-DEBIT-HOSTEL')) {
            return deny();
        }
        return view('fees.miscdebitshostel.index');
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
                $feebilldet->fill([
                    'feehead_id' => $subhead->feehead_id, 'subhead_id' => $subhead_id, 'amount' => $student['charges'],
                    'concession' => 0, 'index_no' => $index_no
                ]);
                $fee_amt = $student['charges'];
                $bill_amt = $student['charges'];
                try {
                    DB::connection(getYearlyDbConn())->beginTransaction();
                    $feebill = new \App\FeeBill();
                    $feebill->fill([
                        'course_id' => $course_id, 'std_type_id' => $student['std_type_id'],
                        'bill_date' => Carbon::now()->format('d-m-Y'), 'install_id' => 0,
                        'concession_id' => 0,
                        'fee_type' => 'Misc Charges', 'fund_type' => 'H', 'fee_amt' => $fee_amt, 'bill_amt' => $bill_amt,
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
        $students =  Student::join('fee_bills', 'fee_bills.std_id', '=', 'students.id')
            ->orderBy(DB::raw('cast(roll_no as signed)'))
            ->where('fee_bills.fee_type', '=', 'Admission_Hostel')
            ->where('fee_bills.fund_type', '=', 'H')
            ->where('students.course_id', '=', $id)
            ->select('students.*')
            ->get();
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

    public function pending($id)
    {
        return Student::havingPendBal([
            'institution' => 'sggs',
            'fund_type' => 'H',
            'course_id' => $id,
        ]);
    }
}
