<?php

namespace App\Http\Controllers\StudentRefund;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentRefund\StudentRefund;
use App\Models\StudentRefund\StudentRefundRequset;
use Gate;

class StudentRefundController extends Controller
{
    public function show(Request $request, $id)
    {
        if (Gate::denies('student-refunds')) {
            return deny();
        }
        $std_refund_request = $id;
        $refund_request = StudentRefundRequset::find($id);
        // dd($refund_request);
        return view('studentrefund.student_refund.create',compact('std_refund_request','refund_request'));
    }

    public function store(Request $request)
    {
        return $this->saveForm($request);
    }

    private function saveForm(Request $request, $id = 0)
    {
        if (Gate::denies('student-refunds')) {
            return deny();
        }
        $this->validateForm($request, $id);
        $student_refund = StudentRefund::findOrNew($request->id);
        $student_refund->std_id = $request->std_id;
        $student_refund->std_ref_req_id = $request->std_ref_req_id;
        $student_refund->release_date = $request->release_date;
        $student_refund->release_remarks = $request->release_remarks;
        $student_refund->release_amt = $request->release_amt;
        $student_refund->released_by = auth()->user()->id;
        $student_refund->save();
        return reply('true',[
            'student_refund' => $student_refund
        ]);
    }

    private function validateForm(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'release_remarks' => 'required|string|max:200',
                'release_amt' => 'required|numeric|max:9999999999.99',
            ],
            [
                'release_remarks.required' => 'Remarks field is required.',
            ]
        );
    }

    public function edit($id)
    {
        $student_refund = StudentRefund::findOrFail($id);
        return view('studentrefund.student_refund.create', compact('student_refund'));
    }

    public function update(Request $request, $id)
    {
        return $this->saveForm($request, $id);
    }
}
