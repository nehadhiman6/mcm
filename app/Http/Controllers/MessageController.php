<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use log;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendSms;
use App\Jobs\SendStudentsSms;
use App\Jobs\SendCourseStudentsSms;
use Gate;

class MessageController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
    public function index(Request $request)
    {
        if( Gate::denies('MESSAGES') ){
            return deny();
        }
        if (!request()->ajax()) {
            return view('messages.sms_class.index');
        }
        $students = \App\Student::existing()->notRemoved()
            ->join('courses', 'courses.id', '=', 'students.course_id')->orderBy('courses.sno');
        if ($request->course_id != 0) {
            $students = $students->where('courses.id', '=', $request->course_id);
        }
        $students = $students->select('students.*', 'course_name');
        return $students->with([
            'last_exam',
            'std_user',
            'admForm' => function ($q) {
                $q->select('id');
            }])->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dispatch(new SendStudentsSms($request->std_ids, $request->msg));
        return response()->json([
            'success' => "Thank you! Your message has been sent successfully.",
        ], 200, ['app-status' => 'success']);
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
        //
    }

    public function sendCourseSms(Request $request)
    {
        dispatch(new SendCourseStudentsSms($request->course_id, $request->msg));
        return response()->json([
            'success' => "Thank you! Your message has been sent successfully.",
        ], 200, ['app-status' => 'success']);
    }
}