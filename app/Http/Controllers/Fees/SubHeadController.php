<?php

namespace App\Http\Controllers\Fees;

use Illuminate\Http\Request;
use App\Http\Requests\SubHeadRequest;
use App\Http\Controllers\Controller;

class SubHeadController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index($id) {
    $feehead = \App\FeeHead::findOrFail($id);
    return view('fees.subheads.index', compact('feehead'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(SubHeadRequest $request) {
    //dd($request->all());
    $subhead = new \App\SubFeeHead();
    $subhead->fill($request->all());
    $subhead->refundable = $request->has("refundable") ? 'Y' : 'N';
    $subhead->save();
    return redirect('feeheads/' . $request->feehead_id . '/subheads');
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
    $subhead = \App\SubFeeHead::findOrFail($id);
    return view('fees.subheads.edit', compact('subhead'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id) {
    $subhead = \App\SubFeeHead::findOrFail($id);
    $subhead->fill($request->all());
    $subhead->refundable = $request->has("refundable") ? 'Y' : 'N';
    $subhead->update();
    return redirect('feeheads/' . $subhead->feehead_id . '/subheads');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function deleteSubhead($id) {
    $subhead = \App\SubFeeHead::findOrFail($id);
    return view('fees.subheads.delete', compact('subhead'));
  }

  public function destroy($id) {
    $subhead = \App\SubFeeHead::findOrFail($id);
    $subhead->delete();
    return back('feeheads/' . $subhead->feehead_id . '/subheads');
  }

   public function updtFeehead(Request $request,$id) {
     //dd('here');
    $subhead = \App\SubFeeHead::findOrFail($id);
    $subhead->fill($request->all());
    $subhead->update();
    return redirect('feeheads/' . $subhead->feehead_id . '/subheads');
  }
}
