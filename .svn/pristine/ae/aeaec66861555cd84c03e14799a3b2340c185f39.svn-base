<?php

namespace App\Http\Controllers\Admissions;

use Illuminate\Http\Request;
use \App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class HostelController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
    public function index(Request $request)
    {
        if (Gate::denies('HOSTEL-STUDENTS-LIST')) {
            return deny();
        }
        if (!request()->ajax()) {
            return View('hostels.index');
        }
        $students = \App\Student::existing()->notRemoved()->hostler()
            ->join('courses', 'courses.id', '=', 'students.course_id')
            ->leftJoin(DB::raw("(select std_id,sum(bill_amt) as amount from fee_bills where fund_type = 'H' and cancelled = 'N' group by 1)a1"),'a1.std_id','=','students.id')
            ->leftJoin(DB::raw("(select std_id,sum(amount) as received from fee_rcpts where fund_type = 'H' and cancelled = 'N' group by 1)a2"),'a2.std_id','=','students.id')
            ->orderBy('courses.sno');
        //   ->where('fee_bills.fund_type', '=', 'H')
        //   ->where('students.adm_cancelled', '=', 'N');
        if ($request->upto_date == '') {
            $students = $students->where('students.adm_date', getDateFormat($request->from_date, "ymd"));
        } else {
            $students = $students->where('students.adm_date', '>=', getDateFormat($request->from_date, "ymd"))
                ->where('students.adm_date', '<=', getDateFormat($request->upto_date, "ymd"));
        }
        if ($request->course_id != 0) {
            $students = $students->where('courses.id', '=', $request->course_id);
        }
        $students = $students->select('students.*', 'course_name',DB::raw("ifnull(a1.amount,0) as amount,ifnull(a2.received,0) as received,ifnull(a1.amount,0)-ifnull(a2.received,0) as pending"))->with('std_user','admForm.hostelData');
        return $students->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (Gate::denies('HOSTEL-ADMISSION')) {
            return deny();
        }
        if (!request()->ajax()) {
            return View('hostels.create');
        }
        $messages = [];
        $rules = [
          'adm_no' => 'required|exists:' . getYearlyDbConn() . '.students,adm_no',
        ];
        $this->validate($request, $rules, $messages);
        $student_det = \App\Student::where('adm_no', '=', $request->adm_no)
          ->with('course')->first();
        // dd($student_det);
        $fee_str = \App\FeeStructure::join('sub_heads', 'sub_heads.id', '=', 'fee_structures.subhead_id')
          ->orderBy('sub_heads.feehead_id')->orderBy('sub_heads.name')
          ->whereCourseId($student_det->course_id)
          ->whereStdTypeId($student_det->std_type_id)->whereInstallmentId(2)
          ->with('subhead', 'subhead.feehead')
          ->select('fee_structures.*', 'sub_heads.feehead_id', DB::raw("fee_structures.opt_default as charge, fee_structures.subhead_id, fee_structures.amount as amt_rec, 0 as concession"))
          ->get();
        $fee_str = $fee_str->groupBy(function ($item, $key) {
            return $item['subhead']['feehead']['name'];
        });
        return compact('student_det', 'fee_str') + ['installment_id' => 2];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\HostelRequest $request)
    {
        if (Gate::denies('HOSTEL-ADMISSION')) {
            return deny();
        }
        $request->save();
        return $request->redirect();
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
