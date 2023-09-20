<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubjectSection;
use Illuminate\Database\Eloquent\Collection;
use App\Student;
use Illuminate\Support\Facades\DB;
use App\SubSectionStudent;
use App\Course;
use Gate;
use App\Subject;

class SectionAllotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($subject);
        // $course = Course::find(1);
        // dd($course->getSubjectStatus(20));
        if (!request()->ajax()) {
            $course = Course::find($request->course_id);
            $subject = Subject::find($request->subject_id);
            return View('academics.sections_maintenance', compact('course', 'subject'));
        }
        return Student::getStrength($request->course_id, $request->subject_id);
    }

    public function subStdStrength(Request $request)
    {
        if (Gate::denies('SUBJECT-WISE-STUDENT-STRENGTH')) {
            return deny();
        }
        if (!request()->ajax()) {
            return View('academics.allot_sections');
        }
        $this->validate($request, [
            'upto_date' => 'required|date_format:d-m-Y',
            'course_id' => 'required|integer|exists:' . getYearlyDbConn() . '.courses,id'
        ]);
        $dt = mysqlDate($request->upto_date);
        $students_1 = Student::existing()->notRemoved()
            ->join('course_subject', 'students.course_id', '=', 'course_subject.course_id')
            ->join('courses', 'students.course_id', '=', 'courses.id')
            ->join(getSharedDb() . 'subjects', 'course_subject.subject_id', '=', 'subjects.id')
            ->select([
                'courses.course_name', 'course_subject.subject_id', 'subjects.subject',
                DB::raw("sum(1) as students"),
            ])
            ->where('students.course_id', '=', $request->course_id)
            ->where('course_subject.sub_type', '=', 'C')
            ->groupBy(DB::raw('1, 2'))->orderBy('courses.sno');
        // return $students->get();

        $students = Student::existing()->notRemoved()->join('courses', 'students.course_id', '=', 'courses.id')
            ->join('student_subs', 'student_subs.student_id', '=', 'students.id')
            ->join(getSharedDb() . 'subjects', 'student_subs.subject_id', '=', 'subjects.id')
            ->select([
                    'courses.course_name', 'student_subs.subject_id', 'subjects.subject',
                    DB::raw("sum(1) as students"),
                ])
            //  ->where('students.adm_cancelled', '=', 'N')
            ->where('students.course_id', '=', $request->course_id)
            ->groupBy(DB::raw('1, 2'))->orderBy('courses.sno');

        return $students->union($students_1)->get();
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
        $rules = [
            'course_id' => 'required|exists:' . getYearlyDbConn() . '.courses,id',
            'section_id' => 'required|exists:' . getYearlyDbConn() . '.sections,id',
            // 'subject_id' => 'required|exists:' . getYearlyDbConn() . '.course_subject,subject_id,course_id,'.intval($request->course_id),
            'subject_id' => 'required|exists:' . getYearlyDbConn() . '.subjects,id',
            'scheme' => 'required',
            'students' => 'required|numeric|min:1',
        ];

        $subSec = SubjectSection::where('course_id', '=', $request->course_id)
            ->where('subject_id', '=', $request->subject_id)
            ->where('section_id', '=', $request->section_id)
            ->first();
        if ($subSec) {
            $rules['subsec'] = 'required';
        }
        $messages = [];
        $messages['subsec.required'] = 'This Section is Already Alloted!';

        $course = Course::find($request->course_id);
        $sub_type = $course->getSubjectStatus($request->subject_id);
        if ($sub_type == 'NA') {
            $rules['no_student'] = 'required';
            $messages['no_student.required'] = 'No student found with this subject!';
        }

        $this->validate($request, $rules, $messages);

        $subject_id = $request->subject_id;
        $subSec = new SubjectSection();
        $subSec->fill($request->all());
        $subsecstd = new Collection();

        $stds = Student::existing()->notRemoved()->orderBy(DB::raw('cast(students.roll_no as signed)'))
            ->leftJoin('sub_sec_dets', function ($join) {
                $join->on('students.id', '=', 'sub_sec_dets.std_id');
            })
            ->leftJoin('subject_sections', function ($join) use ($subject_id) {
                $join->on('subject_sections.id', '=', 'sub_sec_dets.sub_sec_id')
                    // ->on('subject_sections.course_id', '=', 'students.course_id')
                    ->where('subject_sections.subject_id', '=', $subject_id);
            })
            ->where('students.course_id', '=', $request->course_id)
            ->whereNull('subject_sections.id');

        if ($sub_type == 'O') {
            $stds = $stds->join('student_subs', function ($j) {
                $j->on('student_subs.student_id', '=', 'students.id');
            })
            ->where('student_subs.subject_id', '=', $request->subject_id);
        }

        if ($request->scheme != 'all') {
            if ($request->scheme == 'odd') {
                $stds = $stds->whereRaw('cast(students.roll_no as signed) % 2 = 1');
            } else {
                $stds = $stds->whereRaw('cast(students.roll_no as signed) % 2 = 0');
            }
        }

        $stds = $stds->take($request->students)
                    ->select('students.id')
                    ->get();

        if ($stds->count() == 0) {
            return reply("All students are alloted section already!");
        }
        $no = 0;
        foreach ($stds as $std) {
            $det = new SubSectionStudent();
            $det->std_id = $std->id;
            $subsecstd->add($det);
            $no++;
        }
        $subSec->students = $no;
        DB::beginTransaction();
        $subSec->save();
        $subSec->subSecStudents()->saveMany($subsecStudents);
        DB::commit();
        return reply("Section Alloted Successfuly");
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
}
