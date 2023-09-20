<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubjectSection;
use App\SubSectionStudent;
use App\CourseSubject;
use App\Student;
use Gate;

class AllotSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('SECTION-ALLOTMENT')) {
            return deny();
        }
        return view('subject_section.alot_section');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSubjectSection(Request $request)
    {
        $type = $request->type;  //can be 'all' or 'pending'
        $subject_sections = SubjectSection::where('course_id', $request['course_id'])->where('subject_id', $request['subject_id'])
            ->get();
        $subject_sections->load('section');
        $course_subject = CourseSubject::where('course_id', $request['course_id'])->where('subject_id', $request['subject_id'])->first();

        $students = Student::existing()->notRemoved();
        if ($course_subject->honours == 'Y') {
            // dd("here");
            $students = $students->leftJoin('admission_entries', 'admission_entries.id', '=', 'students.adm_entry_id')
                ->leftJoin('sub_sec_students', function ($q) use ($request) {
                    $q->on('sub_sec_students.std_id', '=', 'students.id')
                        ->on('students.course_id', '=', 'sub_sec_students.course_id')
                        ->where('sub_sec_students.subject_id', '=', $request->subject_id);
                })
                ->where('admission_entries.honour_sub_id', '=', $request->subject_id)
                ->where('students.course_id', '=', $request->course_id)->distinct()
                ->select('students.adm_no', 'students.name', 'students.roll_no', 'students.id', 'sub_sec_students.sub_sec_id');
                if ($request->filter_by == "pending") {
                    $students = $students->whereNull('sub_sec_students.sub_sec_id');
                }
            } else if ($course_subject->sub_type == 'C') {
            $students = $students->leftJoin('student_subs', 'student_subs.student_id', '=', 'students.id')
                ->leftJoin('sub_sec_students', function ($q) use ($request) {
                    $q->on('sub_sec_students.std_id', '=', 'students.id')
                        ->on('students.course_id', '=', 'sub_sec_students.course_id')
                        ->where('sub_sec_students.subject_id', '=', $request->subject_id);
                })
                ->where('students.course_id', '=', $request->course_id)->distinct()
                ->select('students.adm_no', 'students.name', 'students.roll_no', 'students.id', 'sub_sec_students.sub_sec_id');
                if ($request->filter_by == "pending") {
                    $students = $students->whereNull('sub_sec_students.sub_sec_id');
                }
                // dd($students->toSql());
        } else {
            $students = $students->join('courses', 'students.course_id', '=', 'courses.id')
                ->join('student_subs', 'student_subs.student_id', '=', 'students.id')
                ->join(getSharedDb() . 'subjects', 'student_subs.subject_id', '=', 'subjects.id')
                ->leftJoin('sub_sec_students', function ($q) use ($request) {
                    $q->on('sub_sec_students.std_id', '=', 'students.id')
                        ->on('students.course_id', '=', 'sub_sec_students.course_id')
                        ->where('sub_sec_students.subject_id', '=', $request->subject_id);
                })
                ->select('students.adm_no', 'students.name', 'students.roll_no', 'students.id', 'sub_sec_students.sub_sec_id')
                ->where('students.adm_cancelled', '=', 'N')
                ->where('students.course_id', '=', $request->course_id)
                ->where('student_subs.subject_id', '=', $request->subject_id);
                if ($request->filter_by == "pending") {
                    $students = $students->whereNull('sub_sec_students.sub_sec_id');
                }
        }
        
       
        $students = $students->get();

        return reply('ok', [
            'subject_sections' => $subject_sections,
            'students' => $students
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
        if ($request->assign_to == 'one') {
            if ($request->student['sub_sec_id'] != 0) {
                $sub_sec_stu = SubSectionStudent::firstOrNew([
                    'course_id' => $request['course_id'],
                    'subject_id' => $request['subject_id'], 'std_id' => $request->student['std_id']
                ]);
                $sub_sec_stu->std_id = $request->student['std_id'];
                $sub_sec_stu->course_id = $request->course_id;
                $sub_sec_stu->subject_id = $request->subject_id;
                $sub_sec_stu->sub_sec_id = $request->student['sub_sec_id'];
                $sub_sec_stu->save();
                return $sub_sec_stu;
            }
        } elseif ($request->assign_to == 'all') {
            foreach ($request->students as $student) {
                $sub_sec_stu =  SubSectionStudent::firstOrNew([
                    'course_id' => $request['course_id'],
                    'subject_id' => $request['subject_id'], 'std_id' => $student['std_id']
                ]);
                $sub_sec_stu->std_id = $student['std_id'];
                $sub_sec_stu->course_id = $request->course_id;
                $sub_sec_stu->subject_id = $request->subject_id;
                $sub_sec_stu->sub_sec_id = $request->sub_sec_id;
                // $sub_sec_stu->save();
            }
            return $sub_sec_stu;
        } elseif ($request->assign_to == 'pending') {
            // return $request->all();
            foreach ($request->students as $student) {
                $sub_sec_stu = SubSectionStudent::where('course_id', $request->course_id)->where('std_id', $student['std_id'])
                    ->where('subject_id', $request->subject_id)->first();
                if (!$sub_sec_stu) {
                    $sub_sec_stu = new SubSectionStudent();
                    $sub_sec_stu->std_id = $student['std_id'];
                    $sub_sec_stu->course_id = $request->course_id;
                    $sub_sec_stu->subject_id = $request->subject_id;
                    $sub_sec_stu->sub_sec_id = $request->sub_sec_id;

                    $sub_sec_stu->save();
                }
            }
            return reply('OK', [
                'sub_sec_stu' => $sub_sec_stu
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function alotSectionsToMany(Request $request)
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
}
