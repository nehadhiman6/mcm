<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\StudentSubsRequest;
use App\Student;
use DB;
use Illuminate\Support\Facades\Gate;
use App\Course;

//use Validator;

class StudentController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
    public function index(Request $request)
    {
        if (Gate::denies('STUDENT-LIST')) {
            return deny();
        }
        if (!request()->ajax()) {
            return view('students.index');
        }
        $messages = [];
        $rules = [
            'from_date' => 'required',
            'upto_date' => 'required',
            'course_id' => 'required|integer|exists:' . getYearlyDbConn() . '.courses,id'
        ];
        $this->validate($request, $rules, $messages);
        $students = \App\Student::existing()->notRemoved()
            ->join('courses', 'courses.id', '=', 'students.course_id')
            ->orderBy('courses.sno');
        // $studentid= \App\Student::pluck('std_user_id')->toArray();
        // $studentuser= \App\StudentUser::where('id',$studentid)->get();
        // dd($studentuser);
        //    ->where('students.adm_cancelled', '=', 'N');
        if ($request->has('from_date')) {
            $students = $students->where('adm_date', '>=', mysqlDate($request->from_date));
        }
        if ($request->has('upto_date')) {
            $students = $students->where('adm_date', '<=', mysqlDate($request->upto_date));
        }
        if ($request->course_id != 0) {
            $students = $students->where('courses.id', '=', $request->course_id);
        }
        $course = Course::findOrFail($request->course_id);
        $students = $students->select('students.*', 'course_name');
        return [
            'students' => $students->with(['std_user',
                'admForm' => function ($q) {
                    $q->select('id');
                },
                'admEntry' => function ($q) {
                    $q->select('id', 'centralized', 'adm_rec_no', 'rcpt_date');
                }])->get(),
            'courseHounoursCount' => count($course->getHonours()),
            ];
        // ->orderBy('course.sno')->get();
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
        if (Gate::denies('EDIT-STUDENT')) {
            return deny();
        }
        $student = \App\Student::with(['course', 'stdType','std_user'])->findOrFail($id);
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, $id)
    {
        if (Gate::denies('EDIT-STUDENT')) {
            return deny();
        }
        $request->save();
        return $request->redirect();
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

    public function stdLedger(Request $request)
    {
//    if (Gate::denies('STUDENT-LEDGER'))
//      return deny();
        if (!request()->ajax()) {
            return View('reports.stdledger');
        }
        $this->validate($request, [
            'adm_no' => 'required|exists:' . getYearlyDbConn() . '.students'
        ]);
        $student = \App\Student::whereAdmNo($request->adm_no)->with('course')->first();
        $qry = "select a1.bill_date,cast(a1.id as char(10)) as billno,concat('Bill No. ',cast(a1.id as char(10))) as part,a1.bill_amt as dramt,0 as cramt,0 as sn,a1.id,'bill' as doc_type,a1.fee_type,0 as bill_id,0 as rec_no from fee_bills a1 where a1.cancelled='N' and a1.std_id = $student->id";
        $qry = getAddedString($qry, "select a1.rcpt_date,concat(cast(a1.fee_bill_id as char(10)),'/',cast(a1.id as char(10))) as billno,concat('Rec No. ',cast(a1.id as char(10))) as part,0 as dramt,a1.amount+a1.concession as cramt,1 as sn,a1.id,'rcpt' as doc_type,'Receipt' as fee_type,a1.fee_bill_id as bill_id,a1.id from fee_rcpts a1 where a1.cancelled='N' and a1.std_id = $student->id", " union all ");
        $qry = "select * from ($qry)t1 order by 1,6";
        $stdlgr = DB::connection(getYearlyDbConn())->select($qry);
        return ['student' => $student, 'stdlgr' => $stdlgr];
    }

    public function editRollNo(Request $request, $id)
    {
        if (Gate::denies('CHANGE-ROLLNO')) {
            return deny();
        }
        $student = \App\Student::with('course')->findOrFail($id);
        $data = ['student' => $student, 'success' => 'Data retrieved successfully!!'];
        if ($request->ajax()) {
            return $data;
        }
        return view('students.change_rollno', compact('student'));
    }

    public function updateRollNo(Request $request, $id)
    {
        if (Gate::denies('CHANGE-ROLLNO')) {
            return deny();
        }

        $this->validate($request, [
            'student.id' => 'required|integer|exists:' . getYearlyDbConn() . '.students,id',
            'roll_no' => 'required|integer|unique:' . getYearlyDbConn() . '.students,roll_no,' . $request->input('student.id', 0),
        ]);

        $student = \App\Student::findOrFail($id);
        $student->roll_no = $request->roll_no;
        $student->adm_no = $request->roll_no;
        $student->update();

        return response()->json(['success' => 'Roll No Updated Successfully', 'roll_no' => $student->roll_no], 200, ['app-status' => 'success']);


        // For khalsa college
        // if ($student->isCourseRollNo() == true) {
        //     return response()->json(['success' => 'Roll no is already in Course Series'], 200, ['app-status' => 'success']);
        //     //  flash()->info('Roll no already in correct  Course Series');
        // } else {
        //     DB::connection(getYearlyDbConn())->beginTransaction();
        //     // $student->roll_no = nextRollno($student->course_id);
        //     $student->update();
        //     DB::connection(getYearlyDbConn())->commit();
        //     return response()->json(['success' => 'Roll No Updated Successfully', 'roll_no' => $student->roll_no], 200, ['app-status' => 'success']);
        // }
    }

    public function editHonour(Request $request, $id)
    {
        if (Gate::denies('CHANGE-HONOUR')) {
            return deny();
        }
        $student = \App\Student::with('admEntry')->findOrFail($id);
        $honoursSubjects = $student->course->getHonours();

        $data = ['student' => $student, 'honoursSubjects' => $honoursSubjects];
        if ($request->ajax()) {
            return reply('OK', $data);
        }
        return view('students.update_honour_sub', compact('student'));
    }

    public function updateHonour(Request $request, $id)
    {
        if (Gate::denies('CHANGE-HONOUR')) {
            return deny();
        }

        $this->validate($request, [
            'std_id' => 'required|integer|exists:' . getYearlyDbConn() . '.students,id',
            // 'roll_no' => 'required|integer|unique:' . getYearlyDbConn() . '.students,roll_no,' . $request->input('student.id', 0),
        ]);

        $student = \App\Student::findOrFail($id);
        $adm_entry = $student->admEntry;
        $adm_entry->honour_sub_id = $request->honour_sub_id;
        $adm_entry->save();

        return reply('Honour Subject Updated Successfully');
    }

    public function getStudent($roll_no, $course_id)
    {
        $courses = Course::where('parent_course_id', $course_id)->pluck('id')->toArray();
        array_push($courses, $course_id);
        $student = Student::where('roll_no', $roll_no)->whereIn('course_id', $courses)->first();
        // $student = Student::where('roll_no',$roll_no)->where(function($query) use ($course_id,$courses){
        //     $query->where('course_id',$course_id);
        //     $query->orWhereIn('course_id',$courses);
        // })->first();
        return response()->json(['success' => 'Found ','student' => $student], 200, ['app-status' => 'success']);
    }
}
