<?php

namespace App\Http\Controllers\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SubjectSection;
use App\AttendanceDetail;
use App\Attendance;
use Illuminate\Support\Facades\DB;
use Log;
use App\SubSectionStudent;
use Gate;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        if(Gate::denies('ATTENDANCE')) {
            return deny();
        }
        if (!request()->ajax()) {
            return View('academics.attendance.sectionlist');
        }

        $rules = [
            'teacher_id' => 'required|integer'
        ];
        if ($request->input('course_id', 0) > 0) {
            $rules['course_id'] = 'integer|exists:' . getYearlyDbConn() . '.courses,id';
        }
        $this->validate($request, $rules);

        $subsecs = SubjectSection::orderBy('subject_id')
            ->where('teacher_id', '=', $request->teacher_id);
        if ($request->input('course_id', 0) > 0) {
            $subsecs = $subsecs->where('course_id', '=', $request->course_id);
        }
        return $subsecs->with(['course', 'subject', 'section'])
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(Gate::denies('ATTENDANCE')) {
            return deny();
        }
        $subsec = SubjectSection::findOrFail($request->subsec_id);
        return $subsec->load('subSecStudents');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Gate::denies('ATTENDANCE')) {
            return deny();
        }
        // return $request->all();
        $this->validate($request, [
            'subsec.id' => 'required|integer|min:1|exists:' . getYearlyDbConn() . '.subject_sections,id',
            'month' => 'required',
        ]);

        DB::connection(getYearlyDbConn())->beginTransaction();
        $attendance = Attendance::firstOrCreate([
                'sub_sec_id' => $request->subsec['id'],
                'month' => $request->month
            ], [
                'lectures' => $request->lectures,
                'teacher_id' => $request->subsec['teacher_id']
            ]);
        foreach ($request->students as $std) {
            $attdet = AttendanceDetail::firstOrNew([
                'attendance_id' => $attendance->id,
                'std_id' => $std['std_id']
            ]);
            Log::info('model info');
            Log::info($attdet);
            if ($attdet->exists == false || ($attdet->attended != intval($std['attended']))) {
                $attdet->attended = $std['attended'];
                $attdet->save();
            }
        }
        DB::connection(getYearlyDbConn())->commit();
        return reply('Ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if (! $request->ajax()) {
            $subsec = SubjectSection::findOrFail($id);
            $subsec->load([
                // 'subSecStudents.student',
                'course', 'teacher', 'subject']);
            //return $subsec->subSecStudents;
            return View('academics.attendance.student_list', compact(['subsec']));
        }
        $this->validate($request, [
            // 'sub_sec_id' => 'required|integer|min:1',
            'month' => 'required',
        ]);

        return reply('Ok', [
            'students' => SubSectionStudent::getAttendance($id, $request->month)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
