<?php

namespace App\Http\Controllers\Reports\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;

class ConsolidatedStudentController extends Controller
{
    public function index(Request $request) 
    {
      if (Gate::denies('consolidated-students'))
        return deny();
      if (!request()->ajax()) {
        return View('reports.student.consolidated_student_list');
      }
      
      $students = \App\Student::existing()->notRemoved()
      ->join('courses', 'courses.id', '=', 'students.course_id')
      ->orderBy('courses.sno');
      
      if ($request->category_id) {
        $students = $students->where('cat_id', '=', $request->category_id);
      }
      
      if ($request->course_id != 0) {
        $students = $students->where('courses.id', '=', $request->course_id);
      }
      
      $students = $students->select('courses.course_name','students.id','students.name', 'students.nationality', 'students.roll_no', 'students.mobile');

      return $students->get();
    }
}
