<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;

class AdmissionRegisterController extends Controller
{

  //
  public function index(Request $request)
  {
    if (Gate::denies('ADMISSION-REGISTER'))
      return deny();
    if (!request()->ajax()) {
      return View('reports.adm_register');
    }
    ini_set('memory_limit', '512M');
    $students = \App\Student::existing()->notRemoved()
      ->join('courses', 'courses.id', '=', 'students.course_id')->orderBy('courses.sno');
    
    if ($request->category_id) {
      $students = $students->where('cat_id', '=', $request->category_id);
    }
    
    if ($request->course_id != 0) {
      $students = $students->where('courses.id', '=', $request->course_id);
    }
   
    $students = $students->select('students.*', 'course_name');
    return $students->with([
      'state',
      'last_exam',
      'std_user',
      'admForm' => function ($q) {
        $q->select('id', 'annual_income');
      },
      'category' => function ($q) {
        $q->select('id', 'name');
      },
      'res_category' => function ($q) {
        $q->select('id', 'name');
      }
    ])->get();
  }
}
