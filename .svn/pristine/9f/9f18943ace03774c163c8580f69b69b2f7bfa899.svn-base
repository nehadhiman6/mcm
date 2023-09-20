<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubjectSection;
use App\Course;
use App\Subject;

class TeacherSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subsecs = SubjectSection::where('course_id', '=', $request->input('course_id', 0))
            ->where('subject_id', '=', $request->input('subject_id', 0))
            ->with(['subject', 'section', 'teacher'])
            ->orderBy('course_id')->get();
       
        if (!$request->ajax()) {
            $course = Course::find($request->course_id);
            $subject = Subject::find($request->subject_id);
            return view('academics.tchr_sec_allocation', compact('course', 'subject', 'subsecs'));
        }

        return $subsecs;
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
        //
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
        $this->validate($request, [
            'teacher_id' => 'required|exists:staff,id'
        ]);
        $subsec = SubjectSection::findOrFail($id);
        $subsec->teacher_id = $request->teacher_id;
        $subsec->update();
        return response()->json([
            'success' => "Teacher Allocated Successfully.",
        ], 200, ['app-status' => 'success']);
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
