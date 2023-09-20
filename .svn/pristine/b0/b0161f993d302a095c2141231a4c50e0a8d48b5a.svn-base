<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Gate;

class StudentCourseController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
    public function index(Request $request, $id)
    {
        if (Gate::denies('CHANGE-COURSE')) {
            return deny();
        }
        $student = \App\Student::with(['course', 'stdSubs', 'stdSubs.subjectGroup', 'stdSubs.subject', 'admEntry'])->findOrFail($id);
        //dd($student);
        $course = $student->course;
        if ($student->course) {
            $compSubs = $student->course->getSubs('C');
            $optionalSubs = $student->course->getSubs('O');
            $compGrps = $student->course->getSubGroups('C');
            $optionalGrps = $student->course->getSubGroups('O');
            $electives = $student->course->getElectives();
            $selectedOpts = [];
            // foreach ($student->stdSubs as $value) {
            //     if ($value->sub_group_id == 0) {
            //         $selectedOpts[] = $value->subject_id;
            //     } else {
            //         if ($value->subjectGroup->type == "C") {
            //             foreach ($compGrps as $key => $val) {
            //                 if ($val['id'] == $value->sub_group_id) {
            //                     $compGrps[$key]['selectedid'] = $value->subject_id;
            //                 }
            //             }
            //         } else {
            //             foreach ($optionalGrps as $key => $val) {
            //                 if ($val['id'] == $value->sub_group_id) {
            //                     $optionalGrps[$key]['selectedid'] = $value->subject_id;
            //                 }
            //             }
            //         }
            //     }
            // }
            foreach ($student->stdSubs as $value) {
                if ($value->sub_group_id > 0 && $value->subjectGroup) {
                    if ($value->subjectGroup->type == "C") {
                        foreach ($compGrps as $key => $val) {
                            if ($val['id'] == $value->sub_group_id) {
                                $compGrps[$key]['selectedid'] = $value->subject_id;
                            }
                        }
                    } elseif ($value->ele_group_id > 0) {
                        foreach ($optionalGrps as $key => $val) {
                            if ($val['id'] == $value->sub_group_id) {
                                $optionalGrps[$key]['selectedid'] = $value->subject_id;
                            }
                        }
                    }
                } else {
                    if ($value->ele_group_id > 0 && $value->electiveGroup) {
                        foreach ($electives as $ele) {
                            if ($ele->id == $student->selected_ele_id) {
                                foreach ($ele->groups as $grp) {
                                    foreach ($grp->details as $detail) {
                                        if ($detail->subject_id == $value->subject_id) {
                                            $grp->selectedid = $value->subject_id;
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        $selectedOpts[] = $value->subject_id;
                    }
                }
            }
        }
        if ($request->ajax()) {
            return compact('student', 'compSubs', 'optionalSubs', 'compGrps', 'optionalGrps', 'selectedOpts', 'course', 'electives') + ['success' => 'Data retreived successfully!!'];
        }
        return view('students.change_course', compact('student', 'compSubs', 'optionalSubs', 'compGrps', 'optionalGrps', 'selectedOpts', 'course'));
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
    public function store(\App\Http\Requests\StudentCourseRequest $request, $id)
    {
        if (Gate::denies('CHANGE-COURSE')) {
            return deny();
        }
        // dd('here');
        $request->save();
        return $request->redirect();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
