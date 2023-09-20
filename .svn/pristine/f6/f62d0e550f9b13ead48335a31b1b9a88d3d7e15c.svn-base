<?php

namespace App\Http\Controllers\Receipts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Gate;

class HostelReceiptController extends Controller
{
    protected $fund_type = 'H';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (Gate::denies('HOSTEL-RECEIPT')) {
            return deny();
        }
        $fund_type = $this->fund_type;
        if (!request()->ajax()) {
            return View('receipts.create', compact('fund_type'));
        }
        $messages = [];
        $rules = [
        'adm_no' => 'required|exists:' . getYearlyDbConn() . '.students'
    ];
        $this->validate($request, $rules, $messages);
        $student = \App\Student::where('adm_no', '=', $request->adm_no)
            ->with('course')->first();
        $fee_rcpt_dets = \App\FeeRcptDet::join('fee_rcpts', 'fee_rcpts.id', '=', 'fee_rcpt_dets.fee_rcpt_id')
        ->groupBy(DB::raw('1,2,3'))
        ->select('fee_rcpt_dets.fee_bill_dets_id', 'fee_rcpt_dets.feehead_id', 'fee_rcpt_dets.subhead_id', DB::raw('sum(fee_rcpt_dets.amount) as amt_rec'))
//        ->where('fee_rcpt_dets.fee_rcpt_id', '=', 2)
        ->where('fee_rcpts.cancelled', '=', 'N')
//        ->get()
    ;
//    dd($fee_rcpt_dets);
        $pend_bal = $student->getPendingFeeDetails('H');

        // $pend_bal = \App\FeeBillDet::join('fee_bills', 'fee_bills.id', '=', 'fee_bill_dets.fee_bill_id')
        // ->leftJoin(DB::raw("({$fee_rcpt_dets->toSql()}) as receipts"), function ($q) {
        //     $q->on('receipts.fee_bill_dets_id', '=', 'fee_bill_dets.id')
        //   ->on('receipts.feehead_id', '=', 'fee_bill_dets.feehead_id')
        //   ->on('receipts.subhead_id', '=', 'fee_bill_dets.subhead_id');
        // })->mergeBindings($fee_rcpt_dets->getQuery())
        // ->where('fee_bills.fund_type', '=', $this->fund_type)
        // ->where('fee_bills.std_id', '=', $student->id)
        // ->where('fee_bills.cancelled', '=', 'N')
        // ->whereRaw('fee_bill_dets.amount-fee_bill_dets.concession-ifnull(receipts.amt_rec,0) > 0')
        // ->select('fee_bill_dets.id', 'fee_bill_dets.feehead_id', 'fee_bill_dets.subhead_id', DB::raw('fee_bill_dets.amount-fee_bill_dets.concession-ifnull(receipts.amt_rec,0) as amount'), DB::raw('0 as concession'), DB::raw('fee_bill_dets.amount-fee_bill_dets.concession-ifnull(receipts.amt_rec,0) as amt_rec'));
        // $pend_bal = $pend_bal->get();

        if ($pend_bal->count() == 0) {
            return response()
              ->json(['no_balance' => ['No dues!!']], 422, ['app-status' => 'error']);
        }
        // $pend_bal = $pend_bal->groupBy(function ($item, $key) {
        //     return $item['subhead']['feehead']['name'];
        // });

        return compact('student', 'pend_bal') + ['fund_type' => $this->fund_type];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\ReceiptRequest $request)
    {
        if (Gate::denies('RECEIPT')) {
            return deny();
        }
        $request->save($this->fund_type);
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
}
