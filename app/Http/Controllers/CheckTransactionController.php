<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use Gate;

class CheckTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Gate::denies('ONLINE-TRANSACTION-STATUS')){
            return deny();
        }
        // $trans = Payment::whereTrcd('46Nc9HnuzKvCyd5')->first();
        // // dd(\Carbon\Carbon::parse($trans->trntime)->setTime(0, 0, 0)->toDateTimeString());
        // return $trans->checkStatus(true);

        if (!$request->ajax()) {
            return view('payments.trn_status');
        }

        $this->validate($request, [
            'trcd' => 'required|exists:' . getYearlyDbConn() . '.payments'
        ]);

        $trans = Payment::whereTrcd($request->trcd)->first();
        $std_user = $trans->std_user;
        if ($std_user->student) {
            $std = $std_user->student;
        } else {
            $std = $std_user->adm_form;
        }

        $std->load(['std_user', 'course']);

        // $result = [];
        $result = $trans->checkStatus(false, true);

        if ($result instanceof  Payment) {
            $status = [
                'status' => $trans->status,
            ];
        } else {
            $status = $result;
        }

        return reply('success', [
            'status' => $status,
            'std' => $std
        ]);
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
}
