<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Gate;

class RemoveStudentController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
    public function index(Request $request)
    {
        if (Gate::denies('REMOVED-STUDENTS-LIST')) {
            return deny();
        }

        if (!request()->ajax()) {
            return View('rmvstudents.index');
        }
        $students = \App\Student::join('courses', 'courses.id', '=', 'students.course_id')->orderBy('courses.sno')
        ->where('students.removed', '=', 'Y');
        if ($request->course_id != 0) {
            $students = $students->where('courses.id', '=', $request->course_id);
        }
        $students = $students->select('students.*', 'course_name')->get();
        return $students;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (Gate::denies('REMOVE-STUDENT')) {
            return deny();
        }

        if (!request()->ajax()) {
            return View('rmvstudents.create');
        }
        $messages = [];
        $rules = [
        'adm_no' => 'required|exists:' . getYearlyDbConn() . '.students,adm_no',
    ];
        $this->validate($request, $rules, $messages);
        $student = \App\Student::where('adm_no', '=', $request->adm_no)
            ->with(['course', 'removed_detail'])->first();
        return compact('student');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//    dd($request->all());
        if (Gate::denies('REMOVE-STUDENT')) {
            return deny();
        }

        $student = \App\Student::where('adm_no', '=', $request->adm_no)->first();
        $student->removed = 'Y';
        DB::connection(getYearlyDbConn())->beginTransaction();
        $student->update();
        $rmv_student = \App\RemovedStudent::firstOrNew(['std_id' => $request->input('student.id', 0)]);
        $rmv_student->fill($request->all());
        $rmv_student->std_id = $student->id;
        $rmv_student->save();
        DB::connection(getYearlyDbConn())->commit();
        return reply('Student Removed Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        if (Gate::denies('REMOVE-STUDENT')) {
            return deny();
        }

        $student = \App\Student::where('id', '=', $id)->whereRemoved('Y')->first();
        if (!$student) {
            return response()->json(['student' => ['No removed student found with this adm no.!!']], 422);
        }
        $student->removed = 'N';
        $removed_detail = $student->removed_detail;
        DB::connection(getYearlyDbConn())->beginTransaction();
        $student->update();
        if ($removed_detail) {
            $removed_detail->delete();
        }
        DB::connection(getYearlyDbConn())->commit();
        return reply('Student Recovered Successfully!');
    }
}
