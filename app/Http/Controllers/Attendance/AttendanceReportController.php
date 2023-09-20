<?php

namespace App\Http\Controllers\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SubjectSection;
use Illuminate\Database\Eloquent\Collection;
use App\Student;
use Illuminate\Support\Facades\DB;
use App\SubSectionStudent;
use App\Course;
use Gate;
use App\Subject;
use App\DailyAttendance;
use App\DailyAttendanceDetail;

class AttendanceReportController extends Controller
{
    public function index(Request $request)
    {
        if(Gate::denies('ATTENDANCE-REPORT')){
            return deny();
        }
        if (!request()->ajax()) {
            return View('academics.attendance_report.index');
        }
        $rules = [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|numeric|digits:4',
            'course_id' => 'required|integer|exists:' . getYearlyDbConn() . '.courses,id',
            'subject_id' => 'required|integer|exists:subjects,id',
            'sub_sec_id' => 'required|integer|exists:' . getYearlyDbConn() . '.subject_sections,id',
            
        ];
        
        
        $subject_section = SubjectSection::findOrFail($request->sub_sec_id);

        if($subject_section->has_sub_subjects == 'Y'){
            $rules += ['sub_subject_sec_id' => 'required|integer|exists:' . getYearlyDbConn() . '.sub_section_dets,id',];
        }

        $this->validate($request, $rules,
        [
            'sub_subject_sec_id.exists' => 'Sub Subject is required for the selected Subject'
        ]);

        $students = DailyAttendanceDetail::join('attendance_daily','attendance_daily.id','=','attendance_daily_dets.daily_attendance_id')            
                    ->join(getSharedDb() . 'subjects','attendance_daily.subject_id','=', 'subjects.id')
                    ->where('attendance_daily.sub_sec_id',$request->sub_sec_id)
                    ->where('attendance_daily.sub_subject_sec_id',$request->sub_subject_sec_id)
                    ->where(DB::raw('month(attendance_daily.attendance_date)'),'=', $request->month)
                    ->where(DB::raw('year(attendance_daily.attendance_date)'),'=', $request->year)
                    ->groupBy(['attendance_daily_dets.std_id', 'attendance_daily.subject_id'])
                    ->select(['attendance_daily_dets.std_id', 'attendance_daily.subject_id','subjects.subject as subject',
                            DB::raw("sum(case WHEN attendance_daily_dets.attendance_status = 'P' THEN 1 else 0 end) as presents"),
                            DB::raw("sum(case WHEN attendance_daily_dets.attendance_status = 'A' THEN 1 else 0 end) as absents"),
                            DB::raw("count(attendance_daily_dets.attendance_status) as total")]
                        )
                    ->with(['student'])
                    ->get();
        return reply(true,[
            'students'=>$students
        ]);
    }
}
