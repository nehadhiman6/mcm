<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class DayBookController extends Controller
{

    //
    public function index(Request $request)
    {
        if (Gate::denies('daybook')) {
            return deny();
        }
        if (!request()->ajax()) {
            return view('reports.daybook_one');
        }
        $messages = [];
        $rules = [
            'upto_date' => 'required',
        ];
        $this->validate($request, $rules, $messages);

        $fee_rcpt_dets = \App\FeeRcptDet::select('fee_rcpt_id', 'feehead_id', DB::raw('sum(amount-concession) as amount'))
            ->groupBy(['fee_rcpt_id', 'feehead_id']);

        $day_book = \App\FeeRcpt::join(DB::raw("({$fee_rcpt_dets->toSql()}) as fee_rcpt_dets"), 'fee_rcpts.id', '=', 'fee_rcpt_dets.fee_rcpt_id')
            ->mergeBindings($fee_rcpt_dets->getQuery())
            ->join('fee_heads', 'fee_heads.id', '=', 'fee_rcpt_dets.feehead_id')
            // ->join('funds', 'funds.id', '=', 'fee_heads.fund_id')
            ->leftJoin('students', 'students.id', '=', 'fee_rcpts.std_id')
            ->leftJoin('courses', 'students.course_id', '=', 'courses.id')
            // ->leftJoin('payments', 'payments.fee_rcpt_id', '=', 'fee_rcpts.id')
            ->where('fee_rcpts.rcpt_date', '=', mysqlDate($request->upto_date))
            // ->where('fee_rcpts.id', '=', 5949)
            ->where('fee_rcpts.cancelled', '=', 'N');

        if ($request->sf != '') {
            $day_book = $day_book->where('courses.sf', '=', $request->sf);
        }

        $day_book = $day_book->where('fee_heads.fund', '=', $request->fund_type);
        $fee_heads = $day_book->distinct()->select('fee_heads.name', 'fee_heads.id')->orderBy('fee_heads.name');
        $fee_heads = $fee_heads->get();
        $day_book->getQuery()->distinct = false;
        $day_book->getQuery()->orders = null;
        $day_book = $day_book->select('fee_rcpt_dets.*', 'students.roll_no', 'students.adm_no', DB::raw('students.name as std_name'), 'courses.course_name', 'fee_rcpts.rcpt_date', 'fee_heads.name', 'fee_rcpts.amount as total')
            ->orderBy('fee_rcpts.id');
        // dd($day_book);
        $day_book = $day_book->get();

        return reply('success', compact('fee_heads', 'day_book'));
    }

    public function daybook2(Request $request)
    {
        if (Gate::denies('daybook2')) {
            return deny();
        }
        if (!request()->ajax()) {
            return view('reports.daybook_two');
        }
        $messages = [];
        $rules = [
            'upto_date' => 'required',
        ];
        $this->validate($request, $rules, $messages);

        $fee_rcpt_dets = \App\FeeRcptDet::select('fee_rcpt_id', 'subhead_id', DB::raw('sum(amount-concession) as amount'))
            ->groupBy(['fee_rcpt_id', 'subhead_id']);

        $day_book = \App\FeeRcpt::join(DB::raw("({$fee_rcpt_dets->toSql()}) as fee_rcpt_dets"), 'fee_rcpts.id', '=', 'fee_rcpt_dets.fee_rcpt_id')
            ->mergeBindings($fee_rcpt_dets->getQuery())
            ->join('sub_heads', 'sub_heads.id', '=', 'fee_rcpt_dets.subhead_id')
            ->join('fee_heads', 'fee_heads.id', '=', 'sub_heads.feehead_id')
            // ->join('funds', 'funds.id', '=', 'fee_heads.fund_id')
            ->leftJoin('students', 'students.id', '=', 'fee_rcpts.std_id')
            ->leftJoin('courses', 'students.course_id', '=', 'courses.id')
            // ->leftJoin('payments', 'payments.fee_rcpt_id', '=', 'fee_rcpts.id')
            ->where('fee_rcpts.rcpt_date', '=', mysqlDate($request->upto_date))
            // ->where('fee_rcpts.id', '=', 5949)
            ->where('fee_rcpts.cancelled', '=', 'N');

        if ($request->sf != '') {
            $day_book = $day_book->where('courses.sf', '=', $request->sf);
        }
    

        $day_book = $day_book->where('fee_heads.fund', '=', $request->fund_type);
        $sub_heads = $day_book->distinct()->select('sub_heads.name', 'sub_heads.group', 'sub_heads.id')
            // ->orderBy('sub_heads.group')
            ->orderBy(DB::raw('ascii(substring(upper(sub_heads.`group`),1,1))+ascii(substring(upper(sub_heads.`group`),2,1))'))
            ->orderBy('sub_heads.name');
        $sub_heads = $sub_heads->get();
        $day_book->getQuery()->distinct = false;
        $day_book->getQuery()->orders = null;
        $day_book = $day_book->select('fee_rcpt_dets.*', 'students.roll_no', 'students.adm_no', DB::raw('students.name as std_name'), 'courses.course_name', 'fee_rcpts.rcpt_date', 'sub_heads.name', 'sub_heads.group', 'fee_rcpts.amount as total')
            ->orderBy('fee_rcpts.id')->orderBy('fee_rcpts.id', 'sub_heads.group');
        // dd($day_book);
        $day_book = $day_book->get();

        return reply('success', compact('sub_heads', 'day_book'));
    }

    public function daybookSummary(Request $request)
    {
        if (Gate::denies('dbsummary')) {
            return deny();
        }
        // dd(monthsList(true));
        if (!request()->ajax()) {
            return view('reports.daybook_summary');
        }

        logger($request->all());
        $messages = [];
        $rules = [
            'month' => 'required',
            'year' => 'required',
            'sf' => 'required'
        ];

        $this->validate($request, $rules, $messages);

        $dt = Carbon::create($request->year, $request->month, 1, 0, 0, 0);
        $dt1 = Carbon::create($request->year1, $request->month1, 1, 0, 0, 0);
        $dates = ([$dt->startOfMonth()->format('Y-m-d'), $dt1->lastOfMonth()->format('Y-m-d')]);

        $day_book = \App\FeeRcpt::join("fee_rcpt_dets", 'fee_rcpts.id', '=', 'fee_rcpt_dets.fee_rcpt_id')
            ->join('sub_heads', 'sub_heads.id', '=', 'fee_rcpt_dets.subhead_id')
            ->join('fee_heads', 'fee_heads.id', '=', 'sub_heads.feehead_id')
            ->leftJoin('students', 'students.id', '=', 'fee_rcpts.std_id')
            ->leftJoin('courses', 'students.course_id', '=', 'courses.id')
            ->whereBetween('fee_rcpts.rcpt_date', $dates)
            ->where('fee_rcpts.cancelled', '=', 'N')
            ->where('fee_heads.fund', '=', $request->fund_type);

        if ($request->sf != 'A') {
            $day_book = $day_book->where('courses.sf', '=', $request->sf);
        }

        $sub_heads = $day_book->distinct()->select('sub_heads.name', 'sub_heads.group', 'sub_heads.id')
            // ->orderBy('sub_heads.group')
            ->orderBy(DB::raw('ascii(substring(upper(sub_heads.`group`),1,1))+ascii(substring(upper(sub_heads.`group`),2,1))'))
            ->orderBy('sub_heads.name');
        $sub_heads = $sub_heads->get();

        $day_book->getQuery()->distinct = false;
        $day_book->getQuery()->orders = null;
        $day_book = $day_book->groupBy(['fee_rcpts.rcpt_date', 'sub_heads.name', 'sub_heads.group'])
            ->select('fee_rcpts.rcpt_date', 'sub_heads.name', 'sub_heads.group', DB::raw('sum(fee_rcpt_dets.amount) as amount, sum(fee_rcpts.amount) as total'))
            ->orderBy('fee_rcpts.rcpt_date')->orderBy('sub_heads.group');
        $day_book = $day_book->get();
        // dd($day_book);

        return reply('success', compact('sub_heads', 'day_book'));
    }
}
