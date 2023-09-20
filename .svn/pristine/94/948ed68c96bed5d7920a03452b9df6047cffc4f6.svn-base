<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
//use App\Http\Controllers\Online\Controller;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;
use App\Payment;

class TransController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return view('payments.show_response', array(
        //     'trans' => $trans,
        //     'status' => $trans->ourstatus,
        // ));
        return '';
        return \App\Payment::find(7308)->checkStatus();
        $qryurl = "https://www.payumoney.com/payment/op/getPaymentResponse";
        $key = config('college.payu.key');
        $client = new \GuzzleHttp\Client();
        Payment::where('status', '=', 'success')->orderBy('id')->chunk(50, function ($trns) {
            $trcds = implode('|', $trns->pluck('trcd')->toArray());
            $response = $client->post($qryurl, [
                'form_params' => [
                    'merchantKey' => $key,
                    'merchantTransactionIds' => $trcds,
                ],
                'headers' => [
                    'authorization' => config('college.payu.auth_header'),
                    'cache-control' => 'no-cache'
                ]
            ]);
            $data = json_decode($response->getBody()->getContents(), true);
            $result = data_get($data, 'result');
            foreach ($result as $r) {
                var_dump(data_get($r, 'postBackParam'));
            }
            dd($data);
        });
        // dd($trcds);

        // if ($response->getStatusCode() != 200) {
        //     if (app()->runningInConsole()) {
        //         return false;
        //     } else {
        //         return Redirect::back();
        //     }
        // }
        // dd($response->getStatusCode());
        // dd($data);
        // Log::info($data);
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

    public function store(Request $request)
    {
        if ($request->exists('status')) {
            $trans = \App\Payment::whereTrcd($request->txnid)->firstOrFail();
            // if (!$trans) {
            //     flash('The transaction does not exist.');
            //     return redirect('stulogin');
            // }
            $trans->status = $request->status;
            $trans->unmappedstatus = $request->unmappedstatus;
            $trans->trid = $request->payuMoneyId;
            $trans->trdate1 = $request->addedon;
            $trans->product = $request->mode;
            $trans->bank_txn = $request->PG_TYPE;
            $trans->ourstatus = "OK";
            $trans->cc_no = $request->cardnum;
            if ($request->status === 'success') {
                $trans->ourstatus = "OK";
                $data = array('trans' => $trans, 'status' => 'SUC',);
                // Mail::send(array('html' => 'emails.payutrn'), $data, function ($message) use ($trans) {
                //     $message->to($trans->email, $trans->student->StdName)->subject('Transaction was Successful!');
                // });
                // $trans->addReceipt();
            } else {
                $trans->ourstatus = "FAL";
            }
            $trans->save();
            //      $trans->load('student', 'student.school');
        } else {
            flash('The requested page does not exist.');
            return redirect('stulogin');
        }
        return view('payments.show_response', array(
            'trans' => $trans,
            'status' => $trans->ourstatus,
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAtom(Request $request)
    {
        // dd($request->all());
        if ($request->f_code && $request->get('mmp_txn', '') != '') {
            $trans = \App\Payment::whereTrcd($request->mer_txn)->firstOrFail();
            // if (!$trans) {
            //     flash('The transaction does not exist.');
            //     return redirect('stulogin');
            // }
            $trans->status = $request->f_code;
            $trans->unmappedstatus = ''; //in case of payu $inputs['unmappedstatus'];
            $trans->trid = $request->mmp_txn;
            $trans->trdate1 = $request->date;
            if ($trans->trdate1 != 'null' && $trans->trdate1 != '') {
                $trans->trdate2 = Carbon::parse($trans->trdate1)->toDateTimeString();
            }
            $trans->product = $request->discriminator;
            $trans->bank_txn = $request->bank_txn;
            $trans->bank = $request->bank_name;
            $trans->cc_no = $request->CardNumber;
            if (strtoupper($request->f_code) === 'OK') {
                $trans->ourstatus = "OK";
                $data = array('trans' => $trans, 'status' => 'SUC',);
                //        Mail::send(array('html' => 'emails.payutrn'), $data, function($message) use($trans) {
                //          $message->to($trans->email, $trans->student->StdName)->subject('Transaction was Successful!');
                //        });
            } else {
                $trans->ourstatus = "FAL";
            }
            $trans->save();
            //      $trans->load('student', 'student.school');
        } else {
            flash('The requested page does not exist.');
            return redirect('stulogin');
        }
        return view('payments.show_response', array(
            'trans' => $trans,
            'status' => $trans->ourstatus,
        ));
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
