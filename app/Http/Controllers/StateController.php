<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\StateRequest;
use Gate;

class StateController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    if (Gate::denies('STATES'))
      return deny();
    $states = \App\State::orderBy('state')->get();
    return view('states.index', compact('states'));
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
  public function store(StateRequest $request) {
    if (Gate::denies('EDIT-STATES'))
      return deny();
    $state = new \App\State();
    $state->fill($request->all());
    $state->save();
    return redirect('states');
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
    if (Gate::denies('EDIT-STATES'))
      return deny();
    $states = \App\State::orderBy('state')->get();
    $state = \App\State::findOrFail($id);
    return view('states.index', compact('states', 'state'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(StateRequest $request, $id) {
    if (Gate::denies('EDIT-STATES'))
      return deny();
    $state = \App\State::findOrFail($id);
    $state->fill($request->all());
    $state->update();
    return redirect('states');
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
