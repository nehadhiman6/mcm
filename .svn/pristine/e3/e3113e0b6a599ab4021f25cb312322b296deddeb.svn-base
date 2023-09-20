<?php

namespace App\Http\Controllers\Online;

use Illuminate\Http\Request;
use App\Http\Controllers\Online\Controller;
use App\Models\StudentRefund\StudentRefundRequset;
use App\Student;

class StudentRefundRequestController extends Controller
{
    public function index(Request $request)
    {
        
            if (!$request->ajax()) {
                return view('online.student_refund_request.index');
            }
            $count = StudentRefundRequset::all()->count();
            $filteredCount = $count;
            $std = auth('students')->user()->adm_form;
            $std_id = $std->std_id;
            $refund_request = StudentRefundRequset::orderBy('id', 'DESC')->where('std_id', $std_id);
            if ($searchStr = $request->input('search.value')) {
                $refund_request = $refund_request->where('', 'like', "%{$searchStr}%");
            }

            $refund_request = $refund_request->take($request->length);
            $filteredCount = $refund_request->count();

            $refund_request = $refund_request->select(['student_refund_requests.*'])->distinct()->get();
            $refund_request->load('student.course','student_refund.released_by','approved_by');
            return [
                'draw' => intval($request->draw),
                'start' => $request->start,
                'data' => $refund_request,
                'recordsTotal' => $count,
                'recordsFiltered' => $filteredCount,
            ];
    }

    public function getStdDetail(Request $request)
    {
        $std = auth('students')->user()->adm_form;
        $student = Student::where('id','=',$std->std_id)->first();
        $student->load('course');
        return reply(
            true,
            [
                'student' => $student
            ]
        );
    }

    public function create()
    {
        return view('online.student_refund_request.create');
    }

    public function store(Request $request)
    {
        return $this->saveForm($request);
    }

    private function saveForm(Request $request, $id = 0)
    {
        // dd($request->all());
        $this->validateForm($request, $id);
        $old_refund= StudentRefundRequset::where('std_id',$request->std_id)->where('approval', '=', 'pending')->where('fund_type',$request->fund_type)->first();
        if($old_refund != null && $old_refund->id != $request->id){
            $this->validate(
                $request,
                ['old_refund' => 'required'],
                ['old_refund.required' => 'Your Old Refund Request is Pending.']
            );
        }
        else{
            $refund_request = StudentRefundRequset::findOrNew($request->id);
            $refund_request->fill($request->all());
            $refund_request->save();
            return reply('true',[
                'refund_request' => $refund_request
            ]);
        }
       
    }

    private function validateForm(Request $request, $id)
    {
        
        $this->validate(
            $request,
            [      
                'fund_type' => 'required|in:H,C',
                'fee_deposite_date' => 'required|date:"d-m-y"',
                'bank_name' => 'required|string|max:100',
                'ifsc_code' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/',
                'bank_ac_no' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/',
                'account_holder_name' => 'required|string|max:100',
                'reason_of_refund' => 'nullable|string|max:200',
                'amount' => 'required|numeric|max:9999999999.99',
            ],
            
        );
    }

    public function edit($id)
    {
        $refund_request = StudentRefundRequset::findOrFail($id);
        return view('online.student_refund_request.create', compact('refund_request'));
    }

    public function update(Request $request, $id)
    {
        return $this->saveForm($request, $id);
    }

    public function refundPrint(Request $request, $id)
    {
        $refund = StudentRefundRequset::findOrFail($id);
        $print = new \App\Printings\StudentRefundPrint();
        $pdf = $print->makepdf($refund);
        $pdf->Output("Refund Request.pdf", 'I');
        exit();
    }

}
