<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Gate;

class FundWiseRepController extends Controller {

  public function index(Request $request) {
    if (Gate::denies('FUND-WISE-COLLECTION'))
      return deny();
    if (!request()->ajax()) {
      return View('reports.fundwise_collection');
    }
    $messages = [];
    $rules = [
        'from_date' => 'required',
        'upto_date' => 'required',
    ];
    $this->validate($request, $rules, $messages);
    $summary = \App\FeeRcptDet::join('fee_rcpts', 'fee_rcpts.id', '=', 'fee_rcpt_dets.fee_rcpt_id')
        ->join('fee_heads', 'fee_heads.id', '=', 'fee_rcpt_dets.feehead_id')
        ->join('funds', 'funds.id', '=', 'fee_heads.fund_id')
        ->leftJoin('payments', 'payments.fee_rcpt_id', '=', 'fee_rcpts.id')
        ->where('fee_rcpts.rcpt_date', '>=', mysqlDate($request->from_date))
        ->where('fee_rcpts.rcpt_date', '<=', mysqlDate($request->upto_date))
        ->where('fee_rcpts.cancelled', '=', 'N');
    if ($request->scope != 'all') {
      if ($request->scope == 'offline')
        $summary = $summary->whereNull('payments.id');
      else
        $summary = $summary->whereNotNull('payments.id');
    }

    if ($request->course_id > 0) {
      $summary->join('fee_bill_dets', 'fee_bill_dets.id', '=', 'fee_rcpt_dets.fee_bill_dets_id')
          ->join('fee_bills', 'fee_bill_dets.fee_bill_id', '=', 'fee_bills.id')
          ->where('fee_bills.course_id', '=', $request->course_id);
    }

    if ($request->fund_type != 'A')
      $summary = $summary->where('fee_heads.fund', '=', $request->fund_type);

    return $summary->select('funds.id', 'funds.name', DB::raw('sum(fee_rcpt_dets.amount) as amount'))
            ->groupBy(DB::raw(1, 2))->get();
  }

  public function details(Request $request) {
//    dd($request->all());
    if (!request()->ajax()) {
      return View('reports.fund_feeheads_collection', $request->only('scope', 'fund_type', 'fund_id', 'from_date', 'upto_date', 'course_id'));
    }
    $messages = [];
    $rules = [
        'from_date' => 'required',
        'upto_date' => 'required',
    ];
    $this->validate($request, $rules, $messages);
    $summary = \App\FeeRcptDet::join('fee_rcpts', 'fee_rcpts.id', '=', 'fee_rcpt_dets.fee_rcpt_id')
        ->join('fee_heads', 'fee_heads.id', '=', 'fee_rcpt_dets.feehead_id')
        ->join('funds', 'funds.id', '=', 'fee_heads.fund_id')
        ->leftJoin('payments', 'payments.fee_rcpt_id', '=', 'fee_rcpts.id')
        ->where('fee_rcpts.rcpt_date', '>=', mysqlDate($request->from_date))
        ->where('fee_rcpts.rcpt_date', '<=', mysqlDate($request->upto_date))
        ->where('fee_rcpts.cancelled', '=', 'N');

    if ($request->fund_id > 0)
      $summary = $summary->where('fee_heads.fund_id', '=', $request->fund_id);
    else
      $summary = $summary->where('fee_heads.fund', '=', $request->fund_type);

    if ($request->scope != 'all') {
      if ($request->scope == 'offline')
        $summary = $summary->whereNull('payments.id');
      else
        $summary = $summary->whereNotNull('payments.id');
    }

    if ($request->course_id > 0) {
      $summary->join('fee_bill_dets', 'fee_bill_dets.id', '=', 'fee_rcpt_dets.fee_bill_dets_id')
          ->join('fee_bills', 'fee_bill_dets.fee_bill_id', '=', 'fee_bills.id')
          ->where('fee_bills.course_id', '=', $request->course_id);
    }

//    if ($request->fund_type != 'A')
//      $summary = $summary->where('fee_heads.fund', '=', $request->fund_type);

    return $summary->select('fee_heads.id', 'fee_heads.name', DB::raw('sum(fee_rcpt_dets.amount) as amount'))
            ->groupBy(DB::raw('1, 2'))->get();
  }

  public function shdetails(Request $request) {
//    dd($request->all());
    if (!request()->ajax()) {
      return View('reports.fund_subheads_collection', $request->only('scope', 'fund_type', 'fund_id', 'from_date', 'upto_date', 'course_id'));
    }
    $messages = [];
    $rules = [
        'from_date' => 'required',
        'upto_date' => 'required',
    ];
    $this->validate($request, $rules, $messages);
    $summary = \App\FeeRcptDet::join('fee_rcpts', 'fee_rcpts.id', '=', 'fee_rcpt_dets.fee_rcpt_id')
        ->join('fee_heads', 'fee_heads.id', '=', 'fee_rcpt_dets.feehead_id')
        ->join('sub_heads', 'sub_heads.id', '=', 'fee_rcpt_dets.subhead_id')
        ->join('funds', 'funds.id', '=', 'fee_heads.fund_id')
        ->leftJoin('payments', 'payments.fee_rcpt_id', '=', 'fee_rcpts.id')
        ->where('fee_rcpts.rcpt_date', '>=', mysqlDate($request->from_date))
        ->where('fee_rcpts.rcpt_date', '<=', mysqlDate($request->upto_date))
        ->where('fee_rcpts.cancelled', '=', 'N');
//        ->where('fee_heads.fund_id', '=', $request->fund_id);

    if ($request->fund_id > 0)
      $summary = $summary->where('fee_heads.fund_id', '=', $request->fund_id);
    else
      $summary = $summary->where('fee_heads.fund', '=', $request->fund_type);

    if ($request->scope != 'all') {
      if ($request->scope == 'offline')
        $summary = $summary->whereNull('payments.id');
      else
        $summary = $summary->whereNotNull('payments.id');
    }

    if ($request->course_id > 0) {
      $summary->join('fee_bill_dets', 'fee_bill_dets.id', '=', 'fee_rcpt_dets.fee_bill_dets_id')
          ->join('fee_bills', 'fee_bill_dets.fee_bill_id', '=', 'fee_bills.id')
          ->where('fee_bills.course_id', '=', $request->course_id);
    }

//    if ($request->fund_type != 'A')
//      $summary = $summary->where('fee_heads.fund', '=', $request->fund_type);

    return $summary->select('sub_heads.id', 'sub_heads.name', DB::raw('sum(fee_rcpt_dets.amount) as amount'))
            ->groupBy(DB::raw('1, 2'))->get();
  }

}
