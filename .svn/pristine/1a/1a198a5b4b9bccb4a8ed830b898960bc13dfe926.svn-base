<?php

namespace App\Http\Controllers\Admissions;

use Illuminate\Http\Request;
use \App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Gate;
use Carbon\Carbon;

class HostelOutsiderController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request) {
    if (Gate::denies('HOSTEL-OUTSIDER-LIST')){
      return deny();
    }
    if (!request()->ajax()) {
      return View('hostels.outsider.index');
    }
    $messages = [];
    $rules = [
      'from_date' => 'required',
      'upto_date' => 'required',
    ];
    $this->validate($request, $rules, $messages);
    $outsiders = \App\Outsider::where('outsiders.adm_cancelled', '=', 'N');
    if ($request->upto_date == '') {
      $outsiders = $outsiders->where('adm_date', getDateFormat($request->from_date, "ymd"));
    } else
      $outsiders = $outsiders->where('adm_date', '>=', getDateFormat($request->from_date, "ymd"))
        ->where('adm_date', '<=', getDateFormat($request->upto_date, "ymd"));
    $outsiders = $outsiders->select('outsiders.*');
    return $outsiders->with([
        'stdType' => function($q) {
          $q->select('id', 'name');
        }])->get();
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Requests\HostelOutsiderRequest $request) {
    if (Gate::denies('HOSTEL-OUTSIDER-FORM'))
      return deny();
    if (!request()->ajax()) {
      return View('hostels.outsider.create');
    }
//    $student_det = \App\Student::where('adm_no', '=', $request->adm_no)
//            ->with('course')->first();
    // dd($student_det);
    $fee_str = \App\FeeStructure::join('sub_heads', 'sub_heads.id', '=', 'fee_structures.subhead_id')
      ->orderBy('sub_heads.feehead_id')->orderBy('sub_heads.name')
      ->whereCourseId(1)
      ->whereStdTypeId($request->input('student_det.std_type_id', 0))->whereInstallmentId(2)
      ->with('subhead', 'subhead.feehead')
      ->select('fee_structures.*', 'sub_heads.feehead_id', DB::raw("fee_structures.opt_default as charge, fee_structures.subhead_id, fee_structures.amount as amt_rec, 0 as concession"))
      ->get();
    $fee_str = $fee_str->groupBy(function($item, $key) {
      return $item['subhead']['feehead']['name'];
    });
    return compact('student_det', 'fee_str', 'adm_entry') + ['installment_id' => 2];
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Requests\HostelOutsiderRequest $request) {
    if (Gate::denies('HOSTEL-OUTSIDER-FORM'))
      return deny();
    $request->save();
    return $request->redirect();
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

  public function ledger(Request $request) {
    if (Gate::denies('HOSTEL-OUTSIDER-LEDGER')){
      return deny();
    }
    if (!request()->ajax()) {
      return View('hostels.outsider.ledger');
    }
    $this->validate($request, [
      'adm_no' => 'required|exists:' . getYearlyDbConn() . '.outsiders'
    ]);
    $student = \App\Outsider::whereAdmNo($request->adm_no)->first();
    $qry = "select a1.bill_date,cast(a1.id as char(10)) as billno,concat('Bill No. ',cast(a1.id as char(10))) as part,a1.bill_amt as dramt,0 as cramt,0 as sn,a1.id,'bill' as doc_type,a1.fee_type,0 as bill_id,0 as rec_no from fee_bills a1 where a1.cancelled='N' and a1.outsider_id = $student->id";
    $qry = getAddedString($qry, "select a1.rcpt_date,concat(cast(a1.fee_bill_id as char(10)),'/',cast(a1.id as char(10))) as billno,concat('Rec No. ',cast(a1.id as char(10))) as part,0 as dramt,a1.amount as cramt,1 as sn,a1.id,'rcpt' as doc_type,'Receipt' as fee_type,a1.fee_bill_id as bill_id,a1.id from fee_rcpts a1 where a1.cancelled='N' and a1.outsider_id = $student->id", " union all ");
    $qry = "select * from ($qry)t1 order by 1,6";
    $stdlgr = DB::connection(getYearlyDbConn())->select($qry);
    return ['student' => $student, 'stdlgr' => $stdlgr];
  }

}
