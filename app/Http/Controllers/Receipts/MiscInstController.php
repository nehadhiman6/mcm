<?php

namespace App\Http\Controllers\Receipts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Gate;

class MiscInstController extends Controller {

  protected $fund_type = 'C';

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request) {
    if (Gate::denies('MISCELLANEOUS-INSTALLMENTS'))
      return deny();
    if (!request()->ajax()) {
      return View('miscinsts.create');
    }
    $messages = [];
    $rules = [
      'adm_no' => 'required|exists:' . getYearlyDbConn() . '.students'
    ];
    $this->validate($request, $rules, $messages);
    $student = \App\Student::where('adm_no', '=', $request->adm_no)
        ->with('course')->first();
    $subheads = \App\SubFeeHead::getSubHeads();
    $pend_bal = $student->getPendingFeeDetails();
    return compact('student', 'subheads', 'pend_bal') + ['fund_type' => $this->fund_type];
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(\App\Http\Requests\MiscInstRequest $request) {
    if (Gate::denies('MISC-INST'))
      return deny();
    $request->save($this->fund_type);
    return $request->redirect();
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id) {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id) {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id) {
    //
  }

}
