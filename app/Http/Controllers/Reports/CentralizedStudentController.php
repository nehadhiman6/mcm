<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;

class CentralizedStudentController extends Controller {

  //
  public function index(Request $request) {
    if (Gate::denies('CENTRALIZED-STUDENT'))
      return deny();
    if (!request()->ajax()) {
      return View('students.centralized_student');
    }
    $students = \App\Student::join('admission_entries', 'admission_entries.id', '=', 'students.adm_entry_id')
      ->join('courses', 'courses.id', '=', 'students.course_id')->orderBy('courses.sno')
      ->where('admission_entries.centralized', '=', 'Y')
      ->where('students.adm_cancelled', '=', 'N');
    if ($request->upto_date == '') {
      $students = $students->where('students.adm_date', getDateFormat($request->from_date, "ymd"));
    } else
      $students = $students->where('students.adm_date', '>=', getDateFormat($request->from_date, "ymd"))
        ->where('students.adm_date', '<=', getDateFormat($request->upto_date, "ymd"));
    if ($request->course_id != 0) {
      $students = $students->where('courses.id', '=', $request->course_id);
    }
    return $students->get();
  }

}
