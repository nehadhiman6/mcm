<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class HostelStrengthController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('HOSTEL-STRENGTH')) {
            return deny();
        }
        if (!request()->ajax()) {
            return view('reports.hostelstrength');
        }
        $messages = [];
        $rules = [
            'upto_date' => 'required',
            //  'scope'
        ];
        $this->validate($request, $rules, $messages);
        $dt = mysqlDate($request->upto_date);
        $students = \App\Student::existing()->notRemoved()->hostler()->join('courses', 'students.course_id', '=', 'courses.id')
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
}
