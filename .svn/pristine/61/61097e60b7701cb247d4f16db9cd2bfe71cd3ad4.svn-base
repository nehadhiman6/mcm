<?php

namespace App\Http\Controllers\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DailyAttendance;
use App\DailyAttendanceDetail;
use App\SubSectionStudent;
use App\SubjectSection;
use Carbon\Carbon;
use DB;
use Gate;

class DailyAttendanceController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('DAILY-ATTENDANCE')) {
            return deny();
        }
        return view('academics.daily_attendance.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSubjectSection(Request $request)
    {
        // $subject_sections = SubjectSection::where('subject_id', $request->subject_id)
        //     ->where('course_id', $request->course_id)->with([ 'sub_sec_details','section' => function($query) {
        //         $query->orderBy('section');
        //     }])
            // ->orderBy('id','desc')
            // ->get();

        $subject_sections = SubjectSection::where('subject_id', $request->subject_id)
            ->where('course_id', $request->course_id)->with([ 'sub_sec_details','section'])
            ->orderBy('id','desc')
            ->get();
                
        // $subject_sections->load(['sub_sec_details','section']);
        return reply('ok', [
            'subject_sections' => $subject_sections
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateForm($request);
      
        $attendance_date = Carbon::createFromFormat('d-m-Y', $request->attendance_date)->format('Y-m-d');
        $attendance = DailyAttendance::firstOrCreate([
            'attendance_date'=>$attendance_date,
            'course_id'=>$request->course_id,
            'subject_id'=>$request->subject_id,
            'sub_sec_id'=>$request->sub_sec_id,
            'sub_subject_sec_id'=>$request->sub_subject_sec_id,
            'period_no'=>$request->period_no,
        ], ['teacher_id'=>auth()->user()->id]);
        $attendance->remarks = $request->remarks;
        $attendance->update();

        if (!$request->students) {
            $attendance_dets = DailyAttendanceDetail::where('daily_attendance_id', $attendance->id)
                            ->where('std_id', $request->student['std_id'])->first();
            if (!$attendance_dets) {
                $attendance_dets = new DailyAttendanceDetail();
                $attendance_dets->std_id = $request->student['std_id'];
                $attendance_dets->daily_attendance_id = $attendance->id;
            }
            $attendance_dets->attendance_status = $request->student['attendance_status'];
            $attendance_dets->remarks = $attendance->remarks;
            $attendance_dets->save();
            return reply('ok', [
                'attendance' => $attendance
            ]);
        } elseif ($request->students) {
            $students_attendence = new \Illuminate\Database\Eloquent\Collection();
            foreach ($request->students as $student) {
                $attendance_dets = DailyAttendanceDetail::firstOrNew(['daily_attendance_id'=>$attendance->id,
                    'std_id'=>$student['std_id']]);
                $attendance_dets->attendance_status = $request['attendance_status'];
                $attendance_dets->remarks = $attendance->remarks;
                $students_attendence->add($attendance_dets);
            }
            DB::connection(getYearlyDbConn())->beginTransaction();
            $attendance->attendance_details()->saveMany($students_attendence);
            DB::connection(getYearlyDbConn())->commit();
            return reply('ok', [
                'attendance' => $attendance
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getStudentsList(Request $request)
    {
        $this->validateForm($request);
        $students = SubSectionStudent::
            leftJoin('attendance_daily', function ($q) use ($request) {
                $q->on('attendance_daily.sub_sec_id', '=', 'sub_sec_students.sub_sec_id')
                    ->where('attendance_date', '=', mysqlDate($request->attendance_date));
            })
            ->leftJoin('attendance_daily_dets', function ($q) {
                $q->on('attendance_daily_dets.daily_attendance_id', '=', 'attendance_daily.id')
                    ->on('attendance_daily_dets.std_id', '=', 'sub_sec_students.std_id');
            })
            ->where('sub_sec_students.sub_sec_id', $request->sub_sec_id)
            ->select(['sub_sec_students.*', 'attendance_daily_dets.attendance_status'])
            ->with('student:id,name,roll_no,adm_no')->get();
        return reply('ok', [
            'students' => $students
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function validateForm($request)
    {
        $rules = [
            'attendance_date' =>'date|date_format:d-m-Y',
            'course_id'=>'required|exists:' . getYearlyDbConn() . '.courses,id',
            'subject_id'=>'required|exists:subjects,id',
            'sub_sec_id'=>'required|exists:' . getYearlyDbConn() . '.subject_sections,id',
            'period_no' =>'nullable|numeric'
        ];
        if ($request->has_sub_subjects =='Y') {
            $rules+=[
                'sub_subject_sec_id' =>'required|exists:' . getYearlyDbConn() . '.sub_section_dets,id'
            ];
        }
        if ($request->has('students')) {
            $rules+=[
               'attendance_status'=>'required|in:P,A,TL',
            ];
        }
        $this->validate($request, $rules, [
            'sub_sec_id.required'=>'Please select subject section',
            'sub_sec_id.exists'=>'Selected section is not Valid',
            'course_id.exists'=>'Course is required',
            'subject_id.exists'=>'Subject is required',
            'attendance_status.in'=>'Attendance Status is required'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
