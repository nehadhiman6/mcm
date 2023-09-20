<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use App\Jobs\AddOnlineReceipt;
use Carbon\Carbon;

class PaytmTransController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return;
        $trans = \App\Payment::findOrFail(60632);
        $trans->addReceipt();
        dd('done!');
        $trans->checkStatus(true);
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
        $paytmChecksum = $request->input('CHECKSUMHASH', '');
        if (!verifychecksum_e($request->all(), config('services.paytm.merchant_key'), $paytmChecksum)) {
            flash('Not a valid request!!');
            return redirect('stulogin');
        }
        Log::info($request->all());

        $t = null;
        if ($request->exists('STATUS')) {
            $trans = \App\Payment::whereTrcd($request->ORDERID)->firstOrFail();
            if ($trans->ourstatus == '') {
                $t = $trans->checkStatus(false, true);
                if ($request->STATUS === 'TXN_SUCCESS') {
                    $job = (new AddOnlineReceipt($trans))->delay(Carbon::now()->addSeconds(4));
                    dispatch($job);
                }
            }
        } else {
            flash('The requested page does not exist.');
            return redirect('stulogin');
        }
        return view('payments.show_response', [
            'trans' => $t ?: $trans,
            'status' => $t ? $t->ourstatus : $trans->ourstatus,
        ]);
        return redirect('paytmtrans/' . $trans->id);

        if ($request->exists('STATUS')) {
            $trans = \App\Payment::whereTrcd($request->ORDERID)->firstOrFail();
            if ($trans->ourstatus == '') {
                $trans->status = $request->STATUS;
                $trans->unmappedstatus = ''; // $request->unmappedstatus;
                $trans->trid = $request->TXNID;
                $trans->cc_no = ''; //$request->cardnum;
                $trans->resp_code = $request->RESPCODE;
                $trans->message = $request->RESPMSG;
                if ($request->STATUS === 'TXN_SUCCESS') {
                    $trans->trdate1 = $request->TXNDATE;
                    $trans->product = $request->PAYMENTMODE;
                    $trans->bank_txn = $request->GATEWAYNAME;
                    $trans->bank = $request->BANKNAME;
                    $trans->ourstatus = "OK";
                    $data = array('trans' => $trans, 'status' => 'SUC',);
                    // Mail::send(array('html' => 'emails.payutrn'), $data, function ($message) use ($trans) {
                    //     $message->to($trans->email, $trans->student->StdName)->subject('Transaction was Successful!');
                    // });
                    // $trans->addReceipt();
                    $job = (new AddOnlineReceipt($trans))->delay(Carbon::now()->addSeconds(4));
                    dispatch($job);
                } else {
                    $trans->ourstatus = "FAL";
                }
                $trans->save();
            }
            // $trans->load('student', 'student.school');
        } else {
            flash('The requested page does not exist.');
            return redirect('stulogin');
        }
        // dd('here');
        return view('payments.show_response', [
            'trans' => $trans,
            'status' => $trans->ourstatus,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return '';
        $trans = \App\Payment::findOrFail($id);
        return view('payments.show_response', [
            'trans' => $trans,
            'status' => $trans->ourstatus,
        ]);
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
