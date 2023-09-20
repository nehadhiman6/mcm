<?php

namespace App\Http\Controllers\Receipts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeeInstRequest;
use Gate;

class HostelFeeInstController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (Gate::denies('HOSTEL-FEE-INSTALLMENTS')) {
            return deny();
        }
        if (!request()->ajax()) {
            return View('feeinstallments.create', ['fund' => 'H']);
        }
        $messages = [];
        $rules = [
            'adm_no' => 'required|exists:' . getYearlyDbConn() . '.students',
            'install_id' => 'required|exists:' . getYearlyDbConn() . '.installments,id',
        ];
        $student_det = \App\Student::where('adm_no', '=', $request->adm_no)
            ->with('course')->first();
        if ($student_det) {
            $feebill = \App\FeeBill::whereStdId($student_det->id)
                ->whereInstallId($request->install_id)
                ->whereCancelled('N')
                ->first();
            if ($feebill) {
                $rules['inst'] = "required";
            }
            $messages['inst.required'] = "Installment Already Received";
        }
        $this->validate($request, $rules, $messages);
        $fee_str = \App\FeeStructure::getFeeInstallmet($student_det, $request->install_id);
        $con_feeheads = \App\FeeHead::where('concession', '=', 'N')->pluck('name');
        return compact('student_det', 'fee_str', 'con_feeheads') + ['installment_id' => $request->install_id];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeeInstRequest $request)
    {
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
