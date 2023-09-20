<?php

namespace App\Http\Controllers\Reports\Staff;

use App\Faculty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Staff\StaffCourse;
use Illuminate\Support\Facades\DB;
use Gate;

class CourseAttendedReportController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('course-attended-report')){
            return deny();

        }
       
        
        if (!request()->ajax()) {

            $form_data = $request->all();
            if(isset($form_data['item_id']) && $form_data['item_id'] != ''){
                $dt2 = getDateFormat(getDateAdd($request->as_on, -1 * $request->year, 'Y'), 'ymd');
                $form_data['date_to'] = getDateFormat($dt2,'dmy');
            }
            // dd($form_data);
            return view('staff.reports.course.index', ['form_data' => $form_data]);
        }
        $this->validate($request, [
            'date_from' => 'required|date_format:d-m-Y',
            'date_to' => 'required|date_format:d-m-Y',
        ]);
        
        $dt1 = getDateFormat($request->date_from, 'ymd');
        $dt2 = getDateFormat($request->date_to, 'ymd');
        $data = StaffCourse::join('staff', 'staff.id', '=', 'staff_courses.staff_id')
            ->join('faculty', 'staff.faculty_id', '=', 'faculty.id')
            ->leftJoin('departments', 'staff.dept_id', '=', 'departments.id')
            ->leftJoin('desigs', 'staff.desig_id', '=', 'desigs.id')
            ->leftJoin('boards', 'staff_courses.university_id', '=', 'boards.id')
            ->whereBetween('staff_courses.begin_date', [$dt1, $dt2])
            ->select([
                DB::raw("trim(concat(ifnull(staff.salutation,''),staff.name,' ',ifnull(staff.middle_name,''),' ',ifnull(staff.last_name,''))) as name"),
                'faculty.faculty',
                'departments.name as depart',
                'desigs.name as desig',
                'staff_courses.courses as course',
                'staff_courses.topic',
                'staff_courses.level',
                'staff_courses.begin_date',
                'staff_courses.end_date',
                'staff_courses.duration_days as duration',
                'staff_courses.org_by',
                DB::raw("trim(concat(staff_courses.sponsored_by,', ',ifnull(staff_courses.other_sponsor,''))) as spon_by"),
                'staff_courses.collaboration_with as coll_with',
                'staff_courses.participate_as as part_as',
                'staff_courses.affi_inst as aff_inst',
                'staff_courses.mode as delivery_mode',
                DB::raw("ifnull(boards.name,staff_courses.other_university) as board_uni"),
                'staff_courses.certificate as cer_link',
                'staff_courses.remarks',
                'staff_courses.staff_id',
                'staff.dept_id',
                'staff.faculty_id',
                'staff.source',
            ])->orderBy('staff_courses.staff_id');

        if (intval($request->depart_id) != 0) {
            $data = $data->where('staff.dept_id', $request->depart_id);
        }
        if (intval($request->faculty_id) != 0) {
            $data = $data->where('staff.faculty_id', $request->faculty_id);
        }
        // dd($request->all());
        if ($request->has('courses') && count($request->courses) > 0) {
            $data = $data->whereIn('staff_courses.courses', $request->courses);
        }

        if ($request->source) {
            $data = $data->where('staff.source', $request->source);
        }

        if (intval($request->staff_id) > 0) {
            $data = $data->where('staff.id', $request->staff_id);
        }

        $data = $data->get();

        // dd($request->all());
        // name
        // faculty
        // depart
        // desig
        // course
        // topic
        // level
        // begin_date
        // end_date
        // duration
        // org_by
        // spon_by
        // coll_with
        // part_as
        // aff_inst
        // delivery_mode
        // board_uni
        // cer_link
        // remarks

        // dd($request->all());
        return $data;
    }
}
