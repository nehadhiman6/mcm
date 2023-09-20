<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ResvCategoryRequest;
use Gate;

class ResvCategoryController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    if (Gate::denies('RESERVED-CATEGORIES'))
      return deny();
    $categories = \App\ResCategory::all();
    return view('resvcategories.index', compact('categories'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    if (Gate::denies('ADD-RESERVED-CATEGORIES'))
      return deny();
    return view('resvcategories.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(ResvCategoryRequest $request) {
    if (Gate::denies('RESERVED-CATEGORIES'))
      return deny();
    $rescat = new \App\ResCategory();
    $rescat->fill($request->all());
    $rescat->save();
    return redirect('resvcategories');
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
    if (Gate::denies('RESERVED-CATEGORIES'))
      return deny();
    $rescat = \App\ResCategory::findOrFail($id);
    return view('resvcategories.edit', compact('rescat'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(ResvCategoryRequest $request, $id) {
    if (Gate::denies('RESERVED-CATEGORIES'))
      return deny();
    $rescat = \App\ResCategory::findOrFail($id);
    $rescat->fill($request->all());
    $rescat->update();
    return redirect('resvcategories');
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
