<?php

namespace App\Http\Controllers\Fees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\FeeStructure;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Gate;

class InstDebitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('installment-debit-list')) {
            return deny();
        }
        // dd('here');
        return view('fees.instdebits.index');
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
            'inst_id' => 'required|exists:' . getYearlyDbConn() . '.installments,id',
        ]);
        $inst_id = $request->inst_id;
        $course_id = $request->course_id;
        $students = Student::orderBy('name')
            ->leftJoin('fee_bills', function ($q) use ($inst_id) {
                $q->on('students.id', '=', 'fee_bills.std_id')
                    ->where('fee_bills.cancelled', '=', 'N')
                    ->where('fee_bills.install_id', '=', $inst_id);
            })->where('students.course_id', '=', $course_id)
            ->whereNull('fee_bills.id')
            ->get(['students.*']);
        // return $students;
        $feestrfull = FeeStructure::where('course_id', '=', $course_id)
            ->where('installment_id', '=', $inst_id)
            ->with(['subhead'])
            ->get();
        foreach ($students as $student) {
            $std_id = $student->id;
            $bill_amt = 0;
            $fee_amt = 0;
            $concession = 0;
            $index_no = 1;
            $feebilldets = new \Illuminate\Database\Eloquent\Collection();
            $feestr = $feestrfull->where('std_type_id', $student->std_type_id);
            // return $feestr;
            if ($feestr->count() > 0) {
                foreach ($feestr as $det) {
                    $feebilldet = new \App\FeeBillDet();
                    $feebilldet->fill([
                        'feehead_id' => $det->subhead->feehead_id, 'subhead_id' => $det['subhead_id'], 'amount' => $det['amount'],
                        'concession' => 0, 'index_no' => $index_no
                    ]);
                    $feebilldets->add($feebilldet);
                    $fee_amt += floatval($det['amount']);
                    $index_no++;
                }
                $bill_amt = $fee_amt;
                try {
                    DB::connection(getYearlyDbConn())->beginTransaction();
                    $feebill = new \App\FeeBill();
                    $feebill->fill([
                        'course_id' => $student->course_id, 'std_type_id' => $student->std_type_id,
                        'bill_date' => Carbon::now()->format('d-m-Y'), 'install_id' => $inst_id,
                        'concession_id' => 0,
                        'fee_type' => 'Installment', 'fund_type' => 'C', 'fee_amt' => $fee_amt, 'bill_amt' => $bill_amt,
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $course_id)
    {
        $inst_id = $request->inst_id;
        $students = Student::orderBy('name')
            ->existing()->notRemoved()
            ->leftJoin('fee_bills', function ($q) use ($inst_id) {
                $q->on('students.id', '=', 'fee_bills.std_id')
                    ->where('fee_bills.cancelled', '=', 'N')
                    ->where('fee_bills.install_id', '=', $inst_id);
            })
            ->where('students.course_id', '=', $course_id)
            ->whereNull('fee_bills.id')
            ->get(['students.*']);
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
