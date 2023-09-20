<?php

namespace App\Http\Controllers\Alumni;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AlumniStudent;
use App\Models\Alumni\AlumniSubject;
use App\CourseSubject;
use DB;
use Gate;

class ExportToAlumniController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('ALUMNI-EXPORT')) {
            return deny();
        }
        if (!request()->ajax()) {
            $courses_grad = \App\Course::orderBy('sno')->whereCourseYear(3)->whereStatus('GRAD')->get()->toArray();
            $courses_pgrad = \App\Course::orderBy('sno')->whereCourseYear(2)->whereStatus('PGRAD')->get()->toArray();
            $courses = array_merge($courses_grad, $courses_pgrad);
            $add_on_courses = \App\AddOnCourse::get();
            return view('alumni.export.index', compact('courses', 'add_on_courses'));
        }

        $this->validate($request, [
            'passout_year' => 'nullable|digits:4',
            'course_id' => 'nullable|required_with:type|numeric',
            'type' => 'nullable|in:UG,PG,Professional,Research'
        ]);

        $courses = AlumniStudent::wherePassoutYear($request->passout_year);
    }

    public function show($course_id)
    {
        if (Gate::denies('ALUMNI-EXPORT')) {
            return deny();
        }
        // dd($course_id);
        if (!request()->ajax()) {
            $session = getFY();
            $students = \App\Student::whereCourseId($course_id)->get()->load('std_user');
            foreach ($students as $student) {
                $alumni_student = \App\AlumniStudent::whereStdId($student->id)->whereSession($session)->first();
                if (!$alumni_student) {
                    $alu_stu = new AlumniStudent();
                    $alu_stu->std_id = $student->id;
                    $alu_stu->name = $student->name;
                    $alu_stu->gender = $student->gender;
                    $alu_stu->father_name = $student->father_name;
                    $alu_stu->mother_name = $student->mother_name;
                    $alu_stu->dob = $student->dob;
                    $alu_stu->email = $student->std_user->email;
                    $alu_stu->mobile = $student->mobile;
                    $alu_stu->session = $session;
                    $alu_stu->course_id = $course_id;
                    $alu_stu->passout_year = substr($alu_stu->session, 4, 7);

                    DB::beginTransaction();
                    $alu_stu->save();
                    foreach ($student->stdSubs as $subject) {
                        $s = new AlumniSubject();
                        $s->alumni_id = $alu_stu->id;
                        $s->sub_id = $subject->subject_id;
                        $s->status = getSubjectType($course_id, $subject->subject_id);
                        $s->save();
                    }
                    // flash()->success('Students Data Exported Successfully!!');
                    DB::commit();
                } else {
                    $alumni_student->course_id = $course_id;
                    $alumni_student->save();
                    // flash()->warning('Students Data Already Exported!!');
                }
            }
        }
        flash()->success('Students Data Exported Successfully!!');
        return redirect()->back();
    }
}
