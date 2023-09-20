<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\BoardRequest;
use Gate;

class BoardController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    if (Gate::denies('BOARD-UNIV'))
      return deny();
    $boards = \App\BoardUniv::all();
    return view('boards.index', compact('boards'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    if (Gate::denies('ADD-BOARD-UNIV'))
      return deny();
    return view('boards.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(BoardRequest $request) {
    if (Gate::denies('EDIT-BOARD-UNIV'))
      return deny();
    $board = new \App\BoardUniv();
    $board->fill($request->all());
    $board->board = $request->has('board');
    $board->migration = $request->has('migration');
    $board->save();
    return redirect('boards');
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
    if (Gate::denies('EDIT-BOARD-UNIV'))
      return deny();
    $board = \App\BoardUniv::findOrFail($id);
    return view('boards.edit', compact('board'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(BoardRequest $request, $id) {
    if (Gate::denies('EDIT-BOARD-UNIV'))
      return deny();
    $board = \App\BoardUniv::findOrFail($id);
    $board->fill($request->all());
    $board->migration = $request->has('migration');
    $board->update();
    return redirect('boards');
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
