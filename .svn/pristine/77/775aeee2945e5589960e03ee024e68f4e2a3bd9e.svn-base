<?php

namespace App\Http\Controllers\Reports;

use App\FeeBill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Gate;

class ConcessionRepController extends Controller
{

  //
  public function index(Request $request)
  {
    if (Gate::denies('CONCESSION-REPORT'))
      return deny();
    if (!request()->ajax()) {
      return View('reports.concession_report');
    }
    $fee_bill = FeeBill::join('students','fee_bills.std_id','=','students.id')
                      ->where('fee_bills.concession', '>', 0)
                      ->where('fee_bills.cancelled', '=', 'N');
    // dd($fee_bill->get());                  
    $students = \App\Student::join('courses', 'courses.id', '=', 'students.course_id')
      ->orderBy('courses.sno')->orderBy('students.id')
      // ->leftJoin('fee_bills','fee_bills.std_id','=','students.id')
      //        ->whereBetween('students.id', [1251, 1500])
      ->where('students.adm_cancelled', '=', 'N')
      ->leftjoin('fee_bills', function ($q) use ($request) {
          $q->on('fee_bills.std_id','=','students.id')
          ->where('fee_bills.concession', '>', 0)
          ->where('fee_bills.cancelled', '=', 'N');
          // if ($request->concession_id != 0)
          //   $q->where('concession_id','=',$request->concession_id);
        })
      // ->whereHas('fee_bills', function ($q) use ($request) {
      //   $q->where('concession', '>', 0)->where('cancelled', '=', 'N');
      //   if ($request->concession_id != 0)
      //     $q->whereConcessionId($request->concession_id);
      // })
      ->select('students.id', 'students.adm_no', 'students.name', 'students.roll_no');
        // dd($students->take(10)->get());
    if ($request->concession_id != 0) {
      $students = $students->where('fee_bills.concession_id', '=', $request->concession_id);
    }
    if ($request->course_id != 0) {
      $students = $students->where('courses.id', '=', $request->course_id);
    }
    $students = $students->get();
    $students->load([
      'fee_bills' => function ($q) use ($request) {
        $q->where('concession', '>', 0)->where('cancelled', '=', 'N')
          ->select('fee_bills.*', DB::raw('fee_bills.concession as con_amt'));
        if ($request->concession_id != 0)
          $q->whereConcessionId($request->concession_id);
      },
      'fee_bills.amt_paid',
      'fee_bills.concession',
      'fee_bills.FeeBillDets' => function ($q) {
        $q->groupBy('fee_bill_id', 'feehead_id')
          ->select('fee_bill_id', 'feehead_id', DB::raw('sum(concession) as concession'))
          ->where('concession', '>', 0);
      },
      'fee_bills.FeeBillDets.feehead'
    ]);
    return $students;
  }
}
