<?php

namespace App\Http\Controllers\Fees;

use App\Installment;
use Illuminate\Http\Request;
use App\Http\Requests\InstallmentRequest;
use App\Http\Controllers\Controller;
use Gate;

class InstallmentController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (Gate::denies('INSTALLMENTS'))
      return deny();
    $installments = Installment::all();
    return view('fees.installments.index', compact('installments'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    if (Gate::denies('INSTALLMENTS'))
      return deny();
    return view('fees.installments.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(InstallmentRequest $request)
  {
    if (Gate::denies('INSTALLMENTS'))
      return deny();
    $installment = new Installment();
    $installment->fill($request->all());
    $installment->save();
    return redirect('installments');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Installment  $installment
   * @return \Illuminate\Http\Response
   */
  public function show(Installment $installment)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Installment  $installment
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    if (Gate::denies('INSTALLMENTS'))
      return deny();
    $inst = Installment::findOrFail($id);
    return view('fees.installments.edit', compact('inst'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Installment  $installment
   * @return \Illuminate\Http\Response
   */
  public function update(InstallmentRequest $request, $id)
  {
    if (Gate::denies('INSTALLMENTS'))
      return deny();
    $inst = Installment::findOrFail($id);
    $inst->fill($request->all());
    $inst->save();
    return redirect('installments');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Installment  $installment
   * @return \Illuminate\Http\Response
   */
  public function destroy(Installment $installment)
  {
    //
  }
}
