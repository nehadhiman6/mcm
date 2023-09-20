<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CategoryRequest;
use Gate;

class CategoryController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    if (Gate::denies('CATEGORIES'))
      return deny();
    $categories = \App\Category::all();
    return view('categories.index', compact('categories'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    if (Gate::denies('ADD-CATEGORIES'))
      return deny();
    return view('categories.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CategoryRequest $request) {
    if (Gate::denies('EDIT-CATEGORIES'))
      return deny();
    $category = new \App\Category();
    $category->fill($request->all());
    $category->save();
    return redirect('categories');
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
    if (Gate::denies('EDIT-CATEGORIES'))
      return deny();
    $category = \App\Category::findOrFail($id);
    return view('categories.edit', compact('category'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(CategoryRequest $request, $id) {
    if (Gate::denies('EDIT-CATEGORIES'))
      return deny();
    $category = \App\Category::findOrFail($id);
    $category->fill($request->all());
    $category->update();
    return redirect('categories');
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
