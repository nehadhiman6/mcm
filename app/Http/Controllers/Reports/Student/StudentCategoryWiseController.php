<?php

namespace App\Http\Controllers\Reports\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;
use DB;

class StudentCategoryWiseController extends Controller
{
    public function index(Request $request) 
    {
        if (Gate::denies('student-category-wise-report'))
          return deny();

        if (!request()->ajax()) {
          return View('reports.student.student_category_wise_report');
        }

        $students = \App\Student::existing()->notRemoved()
        ->join('courses', 'courses.id', '=', 'students.course_id')
        ->orderBy('courses.sno');
        
        $students = $students->select('courses.course_name','students.id','state_id','students.course_id as cours_id','courses.course_id',DB::raw("count(courses.course_name) as str_class_wise"))->groupBy('courses.course_name');

        $category_wise_students = \App\Student::existing()->notRemoved()
            ->select('course_id','cat_id',DB::raw("count(cat_id) as cat_count"))
            ->groupBy(['course_id','cat_id'])
            ->get();       

        $state_wise_students = \App\Student::existing()->notRemoved()->where('cat_id','!=',getForeignCategory())
            ->select('course_id', DB::raw("case students.city when 'chandigah' then 'tricity' when 'panchkula' then 'tricity' when 'mohali' then 'tricity' else 'other' end city, sum(1) as std_count"))
            ->groupBy(DB::raw('1,2'))
            ->get();       

        return reply('OK',[
            'students' => $students->get(),
            'category_wise_students' => $category_wise_students,
            'state_wise_students' => $state_wise_students
        ]);
    }
}
