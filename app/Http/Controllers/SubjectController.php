<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\SubjectRequest;
use Gate;

class SubjectController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    if (Gate::denies('SUBJECTS'))
      return deny();
    $subjects = \App\Subject::all()->load('department:id,name');
    return view('subjects.index', compact('subjects'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    if (Gate::denies('ADD-SUBJECTS'))
      return deny();
    return view('subjects.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(SubjectRequest $request) {
    if (Gate::denies('EDIT-SUBJECTS'))
    return deny();
    $subject = new \App\Subject();
    $subject->fill($request->all());
    // $subject->practical = $request->has('practical') ? 'Y' : 'N';
    $subject->save();
    return redirect('subjects');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id) {
    $subject = \App\Subject::findOrFail($id);
    return $subject;
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id) {
    if (Gate::denies('EDIT-SUBJECTS'))
      return deny();
    $subject = \App\Subject::findOrFail($id);
    return view('subjects.edit', compact('subject'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(SubjectRequest $request, $id) {
    if (Gate::denies('EDIT-SUBJECTS'))
      return deny();
    $subject = \App\Subject::findOrFail($id);
    $subject->fill($request->all());
    // $subject->practical = $request->has('practical') ? 'Y' : 'N';
    $subject->update();
    return redirect('subjects');
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
