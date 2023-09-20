<?php

namespace App\Http\Controllers\Reports;

use App\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Student;
use App\CourseSubject;

class StdStrengthController extends Controller
{
    public function stdStrength(Request $request)
    {
        if (Gate::denies('STUDENT-STRENGTH')) {
            return deny();
        }
        if (!request()->ajax()) {
            return view('reports.stdstrength');
        }
        $messages = [];
        $rules = [
            'upto_date' => 'required',
            //  'scope'
        ];
        $this->validate($request, $rules, $messages);
        $dt = mysqlDate($request->upto_date);
        $students = \App\Student::existing()->notRemoved()->join('courses', 'students.course_id', '=', 'courses.id')
            ->select([
                'courses.course_name',
                DB::raw("sum(case when adm_date < '$dt' then 1 else 0 end) as before_dt"),
                DB::raw("sum(case when adm_date = '$dt' then 1 else 0 end) as on_dt"),
                DB::raw("sum(case when adm_date > '$dt' then 1 else 0 end) as after_dt"),
                DB::raw('sum(1) as total')
            ])
            // ->where('students.adm_cancelled', '=', 'N')
            ->groupBy('courses.course_name')->orderBy('courses.sno');


        if ($request->has('adm_source')) {
            $students = $students->whereAdmSource($request->adm_source);
        }

        // if ($request->has('centralized')) {
        //     $students = $students->whereHas('admEntry', function ($q) use ($request) {
        //         $q->where('centralized', '=', $request->centralized);
        //     });
        // }


        return $students->get();
    }

    public function subStdStrength(Request $request)
    {
        $page = $request->input('page', 'accounts');
        $toolbar = $page == 'accounts' ? 'toolbars._students_toolbar' : 'toolbars._academics_toolbar';
        if (Gate::denies('SUBJECT-WISE-STRENGTH')) {
            return deny();
        }
        if (!request()->ajax()) {
            return View('reports.subwise_stdstrength', compact('toolbar'));
        }
        //    dd($request->all());
        $this->validate($request, [
            'upto_date' => 'required|date_format:d-m-Y',
            'course_id' => 'required|integer|exists:' . getYearlyDbConn() . '.courses,id'
        ]);
        $dt = mysqlDate($request->upto_date);
        $students = Student::existing()->notRemoved()->join('courses', 'students.course_id', '=', 'courses.id')
            ->join('student_subs', 'student_subs.student_id', '=', 'students.id')
            ->join(getSharedDb() . 'subjects', 'student_subs.subject_id', '=', 'subjects.id')
            ->select([
                'courses.course_name', 'student_subs.subject_id', 'subjects.subject',
                DB::raw("sum(1) as students"),
            ])
            //  ->where('students.adm_cancelled', '=', 'N')
            ->where('students.course_id', '=', $request->course_id)
            ->groupBy(DB::raw('1, 2'));

        $students = Student::existing()->notRemoved()->join('courses', 'students.course_id', '=', 'courses.id')
            ->join('admission_entries', 'admission_entries.admission_id', '=', 'students.admission_id')
            ->join(getSharedDb() . 'subjects', 'admission_entries.honour_sub_id', '=', 'subjects.id')
            ->select([
                'courses.course_name', DB::raw('subjects.id as subject_id'), 'subjects.subject',
                DB::raw("sum(1) as students"),
            ])
            ->where('students.course_id', '=', $request->course_id)
            ->groupBy(DB::raw('1, 2'))->orderBy('courses.sno')
            ->unionAll($students);

        //  $data = Course::joinSub($students,'a1','a1.id','=','courses.id')->select([
        //     'a1.course_name', 'a1.subject_id','a1.subject',
        //     DB::raw("sum(students) as students")
        // ])->groupBy(DB::raw('1,2,3'))->orderBy('courses.sno');

        //    if ($request->has('adm_source')) {
        //      $students = $students->whereAdmSource($request->adm_source);
        //    }
        //    if ($request->centralized == 'Y')
        //      $students = $students->whereHas('admEntry', function($q) {
        //        $q->where('centralized', '=', 'Y');
        //      });


        return $students->get();
    }

    public function subwiseStdDetails(Request $request)
    {
        if (!request()->ajax()) {
            return View('reports.subwise_stddetails', $request->only('subject_id', 'course_id', 'subject'));
        }
        return Student::getStrength($request->course_id, $request->subject_id);
    }
}
