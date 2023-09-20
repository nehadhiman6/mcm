<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Gate;
use App\Student;

class PendingBalanceController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('PENDING-BALANCE')) {
            return deny();
        }
        if (!request()->ajax()) {
            return View('reports.pending_balance');
        }

        return Student::havingPendBal($request->all());

        $fee_rcpt_dets = \App\FeeRcptDet::join('fee_bill_dets', 'fee_rcpt_dets.fee_bill_dets_id', '=', 'fee_bill_dets.id')
            ->join('fee_rcpts', 'fee_rcpt_dets.fee_rcpt_id', '=', 'fee_rcpts.id')
            ->where('fee_rcpts.cancelled', '=', 'N')
            ->groupBy('fee_bill_dets.fee_bill_id')
            ->select('fee_bill_dets.fee_bill_id', DB::raw('sum(fee_rcpt_dets.amount) as amount'));

        $fee_bills = \App\FeeBill::leftJoin(DB::raw("({$fee_rcpt_dets->toSql()}) as receipts"), 'fee_bills.id', '=', 'receipts.fee_bill_id')
            ->mergeBindings($fee_rcpt_dets->getQuery())
            ->where('fee_bills.cancelled', '=', 'N');

        if ($request->institution == 'sggs') {
            $fee_bills->groupBy('fee_bills.std_id')
                ->select('fee_bills.std_id', DB::raw('sum(fee_bills.bill_amt)-sum(ifnull(receipts.amount,0)) as bal_amt'));

            if ($request->fund_type != '') {
                $fee_bills = $fee_bills->where('fee_bills.fund_type', '=', $request->fund_type);
            }
            $students = \App\Student::join(DB::raw("({$fee_bills->toSql()}) as fee_bills"), 'students.id', '=', 'fee_bills.std_id')
                ->mergeBindings($fee_bills->getQuery())
                ->existing()
                ->notRemoved()
                ->where('fee_bills.bal_amt', '!=', 0);
            if ($request->course_id != 0) {
                $students = $students->where('course_id', '=', $request->course_id);
            }
            $students = $students->select('students.adm_no', 'students.name', 'students.roll_no', 'students.father_name', 'students.mobile', 'students.course_id', 'fee_bills.bal_amt')
                ->with(['course' => function ($q) {
                    $q->select('id', 'course_name');
                }]);
        } else {
            $fee_bills->groupBy('fee_bills.outsider_id')
                ->select('fee_bills.outsider_id', DB::raw('sum(fee_bills.bill_amt)-sum(ifnull(receipts.amount,0)) as bal_amt'));
            $students = \App\Outsider::join(DB::raw("({$fee_bills->toSql()}) as fee_bills"), 'outsiders.id', '=', 'fee_bills.outsider_id')
                ->mergeBindings($fee_bills->getQuery())
                ->where('fee_bills.bal_amt', '!=', 0);
            $students = $students->select('outsiders.adm_no', 'outsiders.name', 'outsiders.roll_no', 'outsiders.father_name', 'outsiders.mobile', 'outsiders.course_name', 'fee_bills.bal_amt');
        }


//    if (!$request->upto_date == '') {
//      $students = $students->where('adm_date', getDateFormat($request->upto_date, "ymd"));
//    }

        return $students->get();
    }

    public function fundWise(Request $request)
    {
        if (Gate::denies('FUND-WISE-BALANCE')) {
            return deny();
        }
        if (!request()->ajax()) {
            return View('reports.fundwise_balance');
        }

        $fee_rcpt_dets = \App\FeeRcptDet::join('fee_rcpts', 'fee_rcpt_dets.fee_rcpt_id', '=', 'fee_rcpts.id')
            ->where('fee_rcpts.cancelled', '=', 'N')
            ->groupBy('fee_rcpt_dets.fee_bill_dets_id', 'fee_rcpt_dets.feehead_id')
            ->select('fee_rcpt_dets.fee_bill_dets_id', 'fee_rcpt_dets.feehead_id', DB::raw('sum(fee_rcpt_dets.amount+fee_rcpt_dets.concession) as amount'));

        $fee_bills = \App\FeeBillDet::
            leftJoin(
                DB::raw("({$fee_rcpt_dets->toSql()}) as receipts"),
                function ($q) {
                    $q->on('fee_bill_dets.id', '=', 'receipts.fee_bill_dets_id')
                        ->on('fee_bill_dets.feehead_id', '=', 'receipts.feehead_id');
                }
            )
            ->mergeBindings($fee_rcpt_dets->getQuery())
            ->join('fee_bills', 'fee_bill_dets.fee_bill_id', '=', 'fee_bills.id')
            ->leftJoin('students', function ($q) {
                $q->on('students.id', '=', 'fee_bills.std_id');
            })
            ->whereRaw("ifnull(students.removed,'N') = 'N'")
            ->whereRaw("ifnull(students.adm_cancelled,'N') = 'N'")
            ->where('fee_bills.cancelled', '=', 'N')
            ->groupBy('fee_bill_dets.feehead_id')
            ->select('fee_bill_dets.feehead_id', DB::raw('sum(fee_bill_dets.amount-fee_bill_dets.concession)-sum(ifnull(receipts.amount,0)) as bal_amt'));

        if ($request->fund_type != '') {
            $fee_bills = $fee_bills->where('fee_bills.fund_type', '=', $request->fund_type);
        }

        $funds = \App\Fund::join('fee_heads', 'funds.id', '=', 'fee_heads.fund_id')
            ->join(DB::raw("({$fee_bills->toSql()}) as fee_bills"), 'fee_heads.id', '=', 'fee_bills.feehead_id')
            ->mergeBindings($fee_bills->getQuery())
            ->where('fee_bills.bal_amt', '!=', 0)
            ->groupBy(DB::raw('1, 2'))
            ->select('funds.id', 'funds.name', DB::raw('sum(fee_bills.bal_amt) as bal_amt'));

        return $funds->get();
    }

    public function feeheadWise(Request $request)
    {
        if (!request()->ajax()) {
            return View('reports.feehead_wise_balance', $request->only('fund_id', 'fund_type'));
        }

        $fee_rcpt_dets = \App\FeeRcptDet::join('fee_rcpts', 'fee_rcpt_dets.fee_rcpt_id', '=', 'fee_rcpts.id')
        ->where('fee_rcpts.cancelled', '=', 'N')
        ->groupBy('fee_rcpt_dets.fee_bill_dets_id', 'fee_rcpt_dets.feehead_id')
        ->select('fee_rcpt_dets.fee_bill_dets_id', 'fee_rcpt_dets.feehead_id', DB::raw('sum(fee_rcpt_dets.amount+fee_rcpt_dets.concession) as amount'));

        $fee_bills = \App\FeeBillDet::leftJoin(DB::raw("({$fee_rcpt_dets->toSql()}) as receipts"), function ($q) {
            $q->on('fee_bill_dets.id', '=', 'receipts.fee_bill_dets_id')
          ->on('fee_bill_dets.feehead_id', '=', 'receipts.feehead_id');
        })
        ->mergeBindings($fee_rcpt_dets->getQuery())
        ->join('fee_bills', 'fee_bill_dets.fee_bill_id', '=', 'fee_bills.id')
        ->where('fee_bills.cancelled', '=', 'N')
        ->groupBy('fee_bill_dets.feehead_id')
        ->select('fee_bill_dets.feehead_id', DB::raw('sum(fee_bill_dets.amount-fee_bill_dets.concession)-sum(ifnull(receipts.amount,0)) as bal_amt'));

        if ($request->fund_type != '') {
            $fee_bills = $fee_bills->where('fee_bills.fund_type', '=', $request->fund_type);
        }
//    return $fee_bills->take(50)->get();
//    if ($request->course_id != 0) {
//      $fee_bills = $fee_bills->where('course_id', '=', $request->course_id);
//    }

        $funds = \App\Fund::join('fee_heads', 'funds.id', '=', 'fee_heads.fund_id')
            ->join(DB::raw("({$fee_bills->toSql()}) as fee_bills"), 'fee_heads.id', '=', 'fee_bills.feehead_id')
            ->mergeBindings($fee_bills->getQuery())
            ->where('fee_bills.bal_amt', '!=', 0)
            ->groupBy(DB::raw('1, 2'))
            ->select('fee_heads.id', 'fee_heads.name', DB::raw('sum(fee_bills.bal_amt) as bal_amt'));

        if ($request->fund_id > 0) {
            $funds = $funds->where('fee_heads.fund_id', '=', $request->fund_id);
        }

        return $funds->get();
    }

    public function subheadWise(Request $request)
    {
        if (!request()->ajax()) {
            return View('reports.subhead_wise_balance', $request->only('fund_id', 'fund_type'));
        }

        $fee_rcpt_dets = \App\FeeRcptDet::join('fee_rcpts', 'fee_rcpt_dets.fee_rcpt_id', '=', 'fee_rcpts.id')
            ->where('fee_rcpts.cancelled', '=', 'N')
            ->groupBy('fee_rcpt_dets.fee_bill_dets_id', 'fee_rcpt_dets.feehead_id', 'fee_rcpt_dets.subhead_id')
            ->select('fee_rcpt_dets.fee_bill_dets_id', 'fee_rcpt_dets.feehead_id', 'fee_rcpt_dets.subhead_id', DB::raw('sum(fee_rcpt_dets.amount+fee_rcpt_dets.concession) as amount'));

        $fee_bills = \App\FeeBillDet::leftJoin(DB::raw("({$fee_rcpt_dets->toSql()}) as receipts"), function ($q) {
            $q->on('fee_bill_dets.id', '=', 'receipts.fee_bill_dets_id')
                ->on('fee_bill_dets.feehead_id', '=', 'receipts.feehead_id')
                ->on('fee_bill_dets.subhead_id', '=', 'receipts.subhead_id');
        })
            ->mergeBindings($fee_rcpt_dets->getQuery())
            ->join('fee_bills', 'fee_bill_dets.fee_bill_id', '=', 'fee_bills.id')
            ->where('fee_bills.cancelled', '=', 'N')
            ->groupBy('fee_bill_dets.feehead_id', 'fee_bill_dets.subhead_id')
            ->select('fee_bill_dets.feehead_id', 'fee_bill_dets.subhead_id', DB::raw('sum(fee_bill_dets.amount-fee_bill_dets.concession)-sum(ifnull(receipts.amount,0)) as bal_amt'));

        if ($request->fund_type != '') {
            $fee_bills = $fee_bills->where('fee_bills.fund_type', '=', $request->fund_type);
        }

        $funds = \App\Fund::join('fee_heads', 'funds.id', '=', 'fee_heads.fund_id')
        ->join(DB::raw("({$fee_bills->toSql()}) as fee_bills"), 'fee_heads.id', '=', 'fee_bills.feehead_id')
        ->mergeBindings($fee_bills->getQuery())
        ->join('sub_heads', 'sub_heads.id', '=', 'fee_bills.subhead_id')
        ->where('fee_bills.bal_amt', '!=', 0)
        ->groupBy('fee_bills.subhead_id', 'sub_heads.name')
        ->select('fee_bills.subhead_id', 'sub_heads.name', DB::raw('sum(fee_bills.bal_amt) as bal_amt'));

        if ($request->fund_id > 0) {
            $funds = $funds->where('fee_heads.fund_id', '=', $request->fund_id);
        }

        return $funds->get();
    }
}
