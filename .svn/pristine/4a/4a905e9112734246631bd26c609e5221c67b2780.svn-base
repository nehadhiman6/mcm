<?php

namespace App\Http\Controllers\Fees;

use App\Concession;
use Illuminate\Http\Request;
use App\Http\Requests\ConcessionRequest;
use App\Http\Controllers\Controller;
use Gate;

class ConcessionController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    if (Gate::denies('CONCESSIONS'))
      return deny();
    $concessions = \App\Concession::all();
    return view('fees.concessions.index', compact('concessions'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    if (Gate::denies('ADD-CONCESSION'))
      return deny();
    return view('fees.concessions.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(ConcessionRequest $request) {
    if (Gate::denies('EDIT-CONCESSION'))
      return deny();
    $concession = new \App\Concession();
    $concession->fill($request->all());
    $concession->save();
    return redirect('concessions');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Concession  $concession
   * @return \Illuminate\Http\Response
   */
  public function show(Concession $concession) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Concession  $concession
   * @return \Illuminate\Http\Response
   */
  public function edit($id) {
    if (Gate::denies('EDIT-CONCESSION'))
      return deny();
    $cons = Concession::findOrFail($id);
    return view('fees.concessions.edit', compact('cons'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Concession  $concession
   * @return \Illuminate\Http\Response
   */
  public function update(ConcessionRequest $request, $id) {
    if (Gate::denies('EDIT-CONCESSION'))
      return deny();
    $cons = Concession::findOrFail($id);
    $cons->fill($request->all());
    $cons->save();
    return redirect('concessions');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Concession  $concession
   * @return \Illuminate\Http\Response
   */
  public function destroy(Concession $concession) {
    //
  }

}
