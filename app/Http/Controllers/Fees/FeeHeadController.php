<?php

namespace App\Http\Controllers\Fees;

use App\FeeHead;
use App\SubFeeHead;
use Illuminate\Http\Request;
use App\Http\Requests\FeeHeadRequest;
use App\Http\Controllers\Controller;
use Gate;

class FeeHeadController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    if (Gate::denies('FEEHEADS'))
      return deny();
    $feeheads = \App\FeeHead::all();
    return view('fees.feeheads.index', compact('feeheads'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    if (Gate::denies('FEEHEADS'))
      return deny();
    return view('fees.feeheads.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(FeeHeadRequest $request) {
    if (Gate::denies('FEEHEADS'))
      return deny();
    $feehead = new \App\FeeHead();
    $feehead->fill($request->all());
    $feehead->concession = $request->has("concession") ? 'Y' : 'N';
    $feehead->save();
    return redirect('feeheads');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\FeeHead  $feeHead
   * @return \Illuminate\Http\Response
   */
  public function show(FeeHead $feeHead) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\FeeHead  $feeHead
   * @return \Illuminate\Http\Response
   */
  public function edit($feeHead) {
    if (Gate::denies('FEEHEADS'))
      return deny();
    $fee_head = \App\FeeHead::findOrFail($feeHead);
    // dd($fee_head);
    return view('fees.feeheads.edit', compact('fee_head'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\FeeHead  $feeHead
   * @return \Illuminate\Http\Response
   */
  public function update(FeeHeadRequest $request, $feeHead) {
    if (Gate::denies('FEEHEADS'))
      return deny();
    $feehead = FeeHead::findOrFail($feeHead);
    $feehead->fill($request->all());
    $feehead->concession = $request->has("concession") ? 'Y' : 'N';
    $feehead->update();
    return redirect('feeheads');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\FeeHead  $feeHead
   * @return \Illuminate\Http\Response
   */
  public function destroy(FeeHead $feeHead) {
    //
  }

  public function subHeads($id) {
    $feehead = FeeHead::findOrFail($id);
    return view('fees.feeheads.subheads', compact('feehead'));
  }

  public function addSubHeads(Request $request, $id) {
    $feehead = FeeHead::findOrFail($id);
    $subhead = new \App\SubFeeHead();
    $subhead->fill($request->all());
    $subhead->feehead_id = $feehead->id;
    $subhead->save();
    return redirect('feeheads/' . $feehead->id . '/subheads');
  }

  public function editSubHeads($id) {
    $subhead = SubFeeHead::findOrFail($id);
    // $feehead = $subhead->feehead_id;
    return view('fees.feeheads.subheads', compact('subhead', 'feehead'));
  }

  public function updateSubHeads(Request $request, $id) {
    $subhead = SubFeeHead::findOrFail($id);
    $subhead->fill($request->all());
    $subhead->update();
    return redirect('feeheads/' . $subhead->feehead_id . '/subheads');
  }

}
