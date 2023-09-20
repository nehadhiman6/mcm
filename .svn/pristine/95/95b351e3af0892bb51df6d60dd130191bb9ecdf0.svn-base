<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StudentSubjectController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request, $id) {
    if (Gate::denies('STUDENT-SUBJECTS'))
      return deny();
    $student = \App\Student::with(['course', 'stdSubs', 'stdSubs.subjectGroup', 'stdSubs.subject'])->findOrFail($id);
    // dd($student);
    $course = $student->course;
    if ($student->course) {
      $compSubs = $student->course->getSubs('C');
      $optionalSubs = $student->course->getSubs('O');
      $compGrps = $student->course->getSubGroups('C');
      $optionalGrps = $student->course->getSubGroups('O');
      $selectedOpts = [];
      foreach ($student->stdSubs as $value) {
        if ($value->sub_group_id == 0)
          $selectedOpts[] = $value->subject_id;
        else {
          if ($value->subjectGroup->type == "C") {
            foreach ($compGrps as $key => $val) {
              if ($val['id'] == $value->sub_group_id)
                $compGrps[$key]['selectedid'] = $value->subject_id;
            }
          } else {
            foreach ($optionalGrps as $key => $val) {
              if ($val['id'] == $value->sub_group_id)
                $optionalGrps[$key]['selectedid'] = $value->subject_id;
            }
          }
        }
      }
    }
    if ($request->ajax())
      return compact('student', 'compSubs', 'optionalSubs', 'compGrps', 'optionalGrps', 'selectedOpts', 'course') + ['success' => 'Data retreived successfully!!'];
    return view('students.change_subjects', compact('student', 'compSubs', 'optionalSubs', 'compGrps', 'optionalGrps', 'selectedOpts', 'course'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(\App\Http\Requests\StudentSubjectRequest $request, $id) {
    if (Gate::denies('CHANGE-SUBJECTS'))
      return deny();
//    $student = \App\Student::with(['course', 'stdSubs', 'stdSubs.subjectGroup', 'stdSubs.subject'])->findOrFail($id);
    $request->save();
    return $request->redirect();
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Student  $student
   * @return \Illuminate\Http\Response
   */
  public function show(Student $student) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Student  $student
   * @return \Illuminate\Http\Response
   */
  public function edit($id) {
    
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Student  $student
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Student $student) {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Student  $student
   * @return \Illuminate\Http\Response
   */
  public function destroy(Student $student) {
    //
  }

}
