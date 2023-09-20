<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Gate;

class BillCancellationController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (Gate::denies('BILL-CANCELLATION'))
      return deny();
    return view('bills.bill_cancellation');
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
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //    dd($request->all());
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

  // Get Cancellation Detail

  public function getCancelDetail(Request $request)
  {
    // dd($request->all());
    if (Gate::denies('BILL-CANCELLATION'))
      return deny();
    $this->validateForm($request);
    if (intval($request->fee_bill_id) > 0) {
      $fee_bill = \App\FeeBill::findOrFail($request->fee_bill_id);
      $fee_rcpt = $fee_bill->feeRcpt;
    } else {
      if (intval($request->fee_rcpt_id) > 0) {
        $fee_rcpt = \App\FeeRcpt::findOrFail($request->fee_rcpt_id);
      }
      $fee_bill = $fee_rcpt->feeBill;
    }
    if ($fee_bill && strlen($msg = $fee_bill->isCancellable()) > 0)
      return redirect()->back()->with('message', $msg);
    if ($fee_rcpt && !$fee_rcpt->isEditable())
      return redirect()->back()->with('message', 'Previous dated receipts are not cancellable!!');
    $id = $fee_bill ? $fee_bill->id : $fee_rcpt->id;
    $student = $fee_bill && $fee_bill->student ? $fee_bill->student : $fee_rcpt->student;
    //  dd('here');
    return view('bills.confirm_cancellation', compact('fee_bill', 'fee_rcpt', 'id', 'student'));
  }

  private function validateForm($request)
  {
    $this->validate($request, [
      'fee_bill_id' => 'required_without:fee_rcpt_id|nullable|integer|exists:' . getYearlyDbConn() . '.fee_bills,id,cancelled,N',
      'fee_rcpt_id' => 'required_without:fee_bill_id|nullable|integer|exists:' . getYearlyDbConn() . '.fee_rcpts,id,cancelled,N'
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id, Request $request)
  {
    if (Gate::denies('BILL-CANCELLATION'))
      return deny();
    $this->validate(
      $request,
      [
        'fee_bill_id' => 'required_without:fee_rcpt_id|nullable|integer|exists:' . getYearlyDbConn() . '.fee_bills,id,cancelled,N',
        'fee_rcpt_id' => 'required_without:fee_bill_id|nullable|integer|exists:' . getYearlyDbConn() . '.fee_rcpts,id,cancelled,N',
        // 'cancelled_remarks' => 'required|min:1'
        // ], [
        // 'cancelled_remarks.required' => 'Cancellation remarks required!!'
      ]
    );
    //    dd($request->all());
    $fee_bill = \App\FeeBill::find($request->fee_bill_id);
    $fee_rcpt = \App\FeeRcpt::find($request->fee_rcpt_id);
    //dd($fee_rcpt->feeRcptDets());
    if ($fee_bill) {
      if (strlen($msg = $fee_bill->isCancellable()) > 0) {
        return redirect()->back()->with('message', $msg);
      }
      if ($fee_bill->fee_type == 'Admission') {
        $student = $fee_bill->student;
        $admform = $fee_bill->admform;
        $admform->status = 'C';
        $student->adm_cancelled = 'Y';
      }
      if ($fee_bill->fee_type == 'Admission_Hostel_Outsider') {
        $student = $fee_bill->outsider;
        $student->adm_cancelled = 'Y';
      }
      $fee_bill->cancelled = 'Y';
    }
    if ($fee_rcpt) {
      $fee_rcpt->cancelled = 'Y';
    }
    DB::connection(getYearlyDbConn())->beginTransaction();
    if (isset($student))
      $student->save();
    if (isset($admform))
      $admform->save();
    if ($fee_bill)
      $fee_bill->save();
    if ($fee_rcpt)
      $fee_rcpt->save();
    DB::connection(getYearlyDbConn())->commit();
    flash('Bill/Receipt cancelled successfully!!!');
    return redirect()->to('bill/cancel');
    //    return redirect('/');
  }
}
