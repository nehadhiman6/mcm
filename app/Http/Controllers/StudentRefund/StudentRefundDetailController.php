<?php

namespace App\Http\Controllers\StudentRefund;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentRefund\StudentRefundRequset;
use App\Student;
use Gate;

class StudentRefundDetailController extends Controller
{
    public function index(Request $request)
    {  
        if (Gate::denies('refund-requests-details')) {
            return deny();
        }
        if (!$request->ajax()) {
            return view('studentrefund.index');
        }
        $count = StudentRefundRequset::all()->count();
        $filteredCount = $count;
        $refund_request = StudentRefundRequset::orderBy('id', 'DESC');
        if ($searchStr = $request->input('search.value')) {
            $refund_request = $refund_request->where('', 'like', "%{$searchStr}%");
        }

        $refund_request = $refund_request->take($request->length);
        $filteredCount = $refund_request->count();
        $dt1 = getDateFormat($request->date_from, 'ymd');
        $dt2 = getDateFormat($request->date_to, 'ymd');
        if($request->date_from) {
            $refund_request = $refund_request->whereBetween('request_date', [$dt1, $dt2]);
        }
        if ($request->course_id) {
            $std_id = Student::where('course_id',$request->course_id)->pluck('id')->toArray();
            $refund_request = $refund_request->whereIn('std_id',$std_id);
        }

        $refund_request = $refund_request->select(['student_refund_requests.*'])->distinct()->get();
        $refund_request->load('student.course','student_refund','student_refund.released_by','approved_by');
        return [
            'draw' => intval($request->draw),
            'start' => $request->start,
            'data' => $refund_request,
            'recordsTotal' => $count,
            'recordsFiltered' => $filteredCount,
        ];
    }

    public function refundPrint(Request $request, $id)
    {
        if (Gate::denies('refund-requests-print')) {
            return deny();
        }
        $refund = StudentRefundRequset::findOrFail($id);
        $print = new \App\Printings\StudentRefundPrint();
        $pdf = $print->makepdf($refund);
        $pdf->Output("Refund Request.pdf", 'I');
        exit();
    }
}
