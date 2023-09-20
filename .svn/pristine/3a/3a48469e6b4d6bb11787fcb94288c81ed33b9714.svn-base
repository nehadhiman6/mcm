<?php

namespace App\Http\Controllers\Reports\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Staff\StaffPromotion;
use App\Models\Staff\StaffQualification;
use App\Staff;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class PromotionDueReportController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('promotion-due-report')) {
            return deny();
        }
        if (!request()->ajax()) {
            return view('staff.reports.promotion_due_report.index');
        }
        // dd($request->all());
        $rules = [
            'as_on' => 'required|date:"d-m-y"',
            'year' => 'required|numeric|min:1',
            'source' => 'required',
        ];
        $this->validate($request, $rules);
        $dt1 = getDateFormat($request->as_on, 'ymd');
        $promotions = "(select staff_id,max(promotion_date) as p_date from staff_promotion group by 1)a1";
        $staff_qual = "(select staff_id,group_concat(exam separator ',') as qualification from staff_qualification group by 1)a2";
        $dt2 = getDateFormat(getDateAdd($request->as_on, -1 * $request->year, 'Y'), 'ymd');
        $data = Staff::leftJoin('faculty', 'staff.faculty_id', '=', 'faculty.id')
            ->leftJoin('departments', 'staff.dept_id', '=', 'departments.id')
            ->leftJoin(DB::raw($staff_qual), 'a2.staff_id', '=', 'staff.id')
            ->leftJoin(DB::raw($promotions), 'a1.staff_id', '=', 'staff.id')
            ->select(
                'staff.id',
                'staff.name',
                'staff.middle_name',
                'staff.last_name',
                'staff.salutation',
                'faculty.faculty',
                'departments.name as depart',
                'staff.source',
                'a2.qualification',
                'staff.pay_scale',
                'staff.mcm_joining_date as doj',
                'a1.p_date as dop'
            )->where('staff.mcm_joining_date', '<=', $dt2);
        if (intval($request->faculty_id) != 0) {
            $data = $data->where('staff.faculty_id', $request->faculty_id);
        }
        if (intval($request->depart_id) != 0) {
            $data = $data->where('staff.dept_id', $request->depart_id);
        }
        if ($request->source != '') {
            $data = $data->where('staff.source', $request->source);
        }
        if ($request->exam != '') {
            $staff_ids = StaffQualification::where('exam', $request->exam)->pluck('staff_id')->toArray();
            $data = $data->whereIn('staff.id', $staff_ids);
        }
        if ($request->pay_scale != '') {
            $data = $data->where('staff.pay_scale', $request->pay_scale);
        }
        $data = $data->get();
        // teacher_name
        // faculty
        // depart
        // source
        // qualification
        // pay_scale
        // doj
        // work_year
        // orientation
        // refresher
        // short_term
        // fdp
        // reserches
        // course

        // dd($request->all());
        return $data;
    }
}
