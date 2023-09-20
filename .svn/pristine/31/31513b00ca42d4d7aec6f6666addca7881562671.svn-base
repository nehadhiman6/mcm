<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Routing\Controller as BaseController;
use App\Payment;
use Log;
use App\TransactionResponse;
use App\Jobs\AddOnlineReceipt;
use Carbon\Carbon;

class AtomTransController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return '';
        $trans = \App\Payment::findOrFail(15590);
        // dd($trans->initiatedBefore());
        $trans->checkStatus(true);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // var_dump('store');
        $transactionResponse = new TransactionResponse();
        $transactionResponse->setRespHashKey(config("services.atom.res_hash_key"));
        Log::info($request->all());
        if ($request->has('f_code') && $transactionResponse->validateResponse($request->all())) {
            $trans = Payment::whereTrcd($request->mer_txn)->firstOrFail();
            $trans->status = $request->f_code;
            $trans->unmappedstatus = '';
            $trans->trid = $request->mmp_txn;
            $trans->trdate1 = $request->date;
            $trans->product = $request->discriminator;
            $trans->bank = $request->bank;
            $trans->bank_txn = $request->bank_txn;
            $trans->cc_no = $request->CardNumber;
            if (strtoupper($request->f_code) == 'OK') {
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
        } else {
            flash('Invalid Transaction.');
            return redirect('stulogin');
        }

        $view = 'payments.show_response';
        if ($trans->alumni_user_id > 0) {
            $view = 'payments.alumni_response';
        }

        return view($view, [
            'trans' => $trans,
            'status' => $trans->ourstatus,
        ]);
    }
}
