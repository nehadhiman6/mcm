<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Gate;

class ReceiptController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    if (Gate::denies('RECEIPT'))
      return deny();
    //   return view('receipts.get_admno');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request) {
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) {
    //
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

  public function printReceipt(Request $request, $id) {
    //
    $feercpt = \App\FeeRcpt::find($id);
//    dd($feercpt->billRcptDets);

    $rcpt = new \App\Printings\RecPrint();
    $pdf = $rcpt->makepdf($feercpt);
    $pdf->Output("Rec$feercpt->id.pdf", 'I');
  }

}
