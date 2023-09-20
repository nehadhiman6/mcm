<?php

namespace App\Http\Controllers\Reports\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Staff\StaffQualification;
use Illuminate\Support\Facades\DB;
use Gate;

class QualificationReportController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('qualification-report')){
            return deny();

        }
        if (!request()->ajax()) {
            return view('staff.reports.qualification.index');
        }
        $rules = [
            'from_year' => 'required|date:"d-m-y"',
            'to_year' => 'required|date:"d-m-y"',
        ];
        $this->validate($request, $rules);
        $yr1 = getDateSub($request->from_year, 'Y');
        $yr2 = getDateSub($request->to_year, 'Y');
        $data = StaffQualification::join('staff', 'staff.id', '=', 'staff_qualification.staff_id')
            ->join('departments', 'staff.dept_id', '=', 'departments.id')
            ->join('desigs', 'staff.desig_id', '=', 'desigs.id')
            ->leftJoin('faculty', 'staff.faculty_id', '=', 'faculty.id')
            ->leftJoin('boards', 'staff_qualification.institute_id', '=', 'boards.id')
            ->select([
                'staff_qualification.*',
                DB::raw("trim(concat(ifnull(staff.salutation,''),' ',staff.name,' ',ifnull(staff.middle_name,''),' ',ifnull(staff.last_name,''))) as name"),
                'faculty.faculty', 'departments.name as depart', 'desigs.name as desig',
                DB::raw("ifnull(boards.name,staff_qualification.other_institute) as board_uni"),'staff.dept_id', 'staff.faculty_id','staff.source'
            ])->whereBetween(DB::raw("cast(staff_qualification.year as signed)"), [$yr1, $yr2]);

        if ($request->course_type != '0') {
            $exams = getUGPGExams();
            $classes = [];
            foreach ($exams as $exam) {
                if ($exam['grad'] == $request->course_type) {
                    $classes[] = $exam['class'];
                }
            }
            $data = $data->whereIn('exam', $classes);
        }
        if ($request->exam != '') {
            $data = $data->where('exam', $request->exam);
        }
        if (intval($request->faculty_id) != 0) {
            $data = $data->where('staff.faculty_id', $request->faculty_id);
        }
        if (intval($request->depart_id) != 0) {
            $data = $data->where('staff.dept_id', $request->depart_id);
        }
        if ($request->source) {
            $data = $data->where('staff.source', $request->source);
        }
        // dd($request->all());
        $data = $data->get();
        // name
        // faculty
        // depart
        // desig
        // exam_type
        // exam
        // pg_sub
        // board_uni
        // year
        // type
        // per_cgpa
        // division
        // distintion
        // dd($request->all());
        return $data;
    }
}
