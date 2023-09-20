<?php

namespace App\Http\Controllers\StudentRefund;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentRefund\StudentRefundRequset;
use Gate;

class ApprovalRefundController extends Controller
{
    public function show(Request $request, $id)
    {
        if($request->approval == 'approved'){
            if (Gate::denies('approve')) {
                    return deny();
                }
        }
        else{
            if(Gate::denies('cancel')) {
                return deny();
            }
        }
        
        $approval = $request->approval;
        $refund_request = StudentRefundRequset::find($id);
        $refund_request->load('student.course');
        return view('studentrefund.approval_refund.approval_create',compact('approval','id','refund_request'));
        
    }

    public function store(Request $request)
    {
        return $this->saveForm($request);
    }

    private function saveForm(Request $request, $id = 0)
    {
        $this->validateForm($request, $id);
        $refund_request = StudentRefundRequset::findOrFail($request->id);
        $refund_request->approval_remarks = $request->approval_remarks;
        $refund_request->approval_date = $request->approval_date;
        $refund_request->approval = $request->approval;
        $refund_request->approved_by = auth()->user()->id;
        $refund_request->save();
        return reply('true',[
            'refund_request' => $refund_request
        ]);
    }

    private function validateForm(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'approval_remarks' => 'required|string|max:200',
            ],
            [
                'approval_remarks.required' => 'Remarks field is required.',
            ]
        );
    }

    public function update(Request $request, $id)
    {
        return $this->saveForm($request, $id);
    }
}
