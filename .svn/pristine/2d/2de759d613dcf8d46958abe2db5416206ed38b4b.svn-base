<?php

namespace App\Http\Controllers\Reports;

use Gate;
use App\FeeRcpt;
use App\FeeBillDet;
use App\FeeRcptDet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FeeReportsController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
    public function index(Request $request)
    {
        if (Gate::denies('FEE-COLLECTION')) {
            return deny();
        }
        if (!request()->ajax()) {
            return View('reports.feecollections');
        }
        $messages = [];
        $rules = [
            'from_date' => 'required',
            'upto_date' => 'required',
        ];
        $this->validate($request, $rules, $messages);
        $feercpts = \App\FeeRcpt::orderBy('fee_rcpts.rcpt_date')->orderBy('fee_rcpts.id')
            ->join('students', 'students.id', '=', 'fee_rcpts.std_id');

        if (strlen($request->fund_type) > 0) {
            // $feercpts = $feercpts->whereHas('feeRcptDets.feeHead', function ($q) use ($request) {
            //     $q->where('fund', '=', $request->fund_type);
            // });
            $feercpts = $feercpts->where('fund_type','=',$request->fund_type);
            // $feercpts = $feercpts->join('fee_rcpt_dets','fee_rcpt_dets.fee_rcpt_id','=','fee_rcpts.id')
            //             ->join('fee_heads','fee_rcpt_dets.feehead_id','=','fee_heads.id')
            //             ->where('fee_heads.fund', '=', $request->fund_type);
            
        }
        if ($request->upto_date == '') {
            $feercpts = $feercpts->where('fee_rcpts.rcpt_date', getDateFormat($request->from_date, "ymd"));
        } else {
            $feercpts = $feercpts->where('fee_rcpts.rcpt_date', '>=', getDateFormat($request->from_date, "ymd"))
        ->where('fee_rcpts.rcpt_date', '<=', getDateFormat($request->upto_date, "ymd"));
        }

        if ($request->course_id > 0) {
            $feercpts->where('students.course_id', '=', $request->course_id);
        }

        if (in_array($request->sf, ['N', 'Y'])) {
            $feercpts = $feercpts->join('courses', 'students.course_id', '=', 'courses.id')
                ->where('courses.sf', '=', $request->sf);
        }

        if ($request->pay_type != '') {
            $feercpts = $feercpts->where('fee_rcpts.pay_type', $request->pay_type);
        }

        if (!$request->cancelled || $request->cancelled == 'false') {
            $feercpts = $feercpts->where('fee_rcpts.cancelled', 'N');
        } else {
            $feercpts = $feercpts->where('fee_rcpts.cancelled', 'Y');
        }

        if (intval($request->user_id) > 0) {
            $feercpts = $feercpts->where('fee_rcpts.created_by', intval($request->user_id));
        }

        if ($request->scope == 'online') {
            $feercpts = $feercpts->join('payments', 'payments.fee_rcpt_id', '=', 'fee_rcpts.id');
            // $feercpts->has('online_trn');
        }

        if ($request->scope == 'offline') {
            $feercpts = $feercpts->leftjoin('payments', 'payments.fee_rcpt_id', '=', 'fee_rcpts.id')
                ->whereNull('payments.id');
            // $feercpts->doesntHave('online_trn');
        }
        
        $receipts = $feercpts->select('fee_rcpts.id', 'fee_rcpts.rcpt_date', 'fee_rcpts.pay_type', 'fee_rcpts.chqno', 'fee_rcpts.details', DB::raw('case when fee_rcpts.pay_type="B" then fee_rcpts.amount else 0 end as bank'), DB::raw('case when fee_rcpts.pay_type="C" then fee_rcpts.amount else 0 end as cash'), 'fee_rcpts.amount', 'fee_rcpts.std_id', 'fee_rcpts.outsider_id', 'fee_rcpts.created_by')->get();

        $receipts->load([
            'user_created' => function ($q) {
                $q->select('id', 'name');
            },
            'student' => function ($q) {
                $q->select('id', 'adm_no', 'name', 'father_name', 'course_id');
            },
            'student.course' => function ($q) {
                $q->select('id', 'course_name');
            },
            'online_trn' => function ($q) {
                $q->select('id', 'fee_rcpt_id', 'trid', 'trcd');
            },
            'outsider',
        ]);

        $summary =$feercpts->select('fee_rcpts.created_by','fee_rcpts.id', DB::raw("sum(case when fee_rcpts.pay_type = 'B' then fee_rcpts.amount else 0 end) as bank"), DB::raw("sum(case when fee_rcpts.pay_type = 'B' then 0 else fee_rcpts.amount end) as cash"), DB::raw('sum(fee_rcpts.amount) amount'))
        ->groupBy('fee_rcpts.created_by')
        ->with('user_created')->get();
        return compact('receipts', 'summary');
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

    public function stdFeeDetails(Request $request)
    {
        if (Gate::denies('SW-FEE-DETAILS')) {
            return deny();
        }
        if (!request()->ajax()) {
            return View('reports.stdwise_feedetails');
        }
    }
}
