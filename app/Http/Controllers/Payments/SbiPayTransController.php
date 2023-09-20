<?php

namespace App\Http\Controllers\Payments;

use App\Jobs\AddOnlineReceipt;
use App\Lib\AESEnc;
use Illuminate\Http\Request;
//use App\Http\Controllers\Online\Controller;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;
use App\Payment;

class SbiPayTransController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return;
        $aesenc = new AESEnc();
        // $t = $aesenc->decrypt("WgQ+O7QEOEa3D5caZc6B1Gz9Tu0mKj5ibvkzUUUfhga0YPsqdSJ8gXQBqKZOXn5a", "Yu8YqvgitfJgY6bz/NmEqQ==");
        // $t = $aesenc->decrypt("bbx8wXDIHiP9tic59l7qdZzYBxN8PKSML/QK4r4Vp/cjOC6hBaEK4bCMcYFKhxK7OBZgSeQQ8j9uwDNzPdD8PPRgaH2WeT7UrbjwqV+xvwU=", "wg5IqLep95yDeOBqMG3IdQ==");
        // $t = $aesenc->encrypt("A7C9F96EEE0602A61F184F4F1B92F0566B9E61D98059729EAD3229F882E81C3A", "wg5IqLep95yDeOBqMG3IdQ==");
        $t = $aesenc->decrypt2("55wqVIlJQLuF/Rs27E0joKHk3cCeJ7m7/MOjqWXg8dAEKl2Glj9SyfdUGStRLO/3DNEft0eVGnwXoLTIJGf6w4JDH/+imPnvZmnrVFBv7xU=", "wg5IqLep95yDeOBqMG3IdQ==");
        dd($t);
        dd(base64_encode($t));
        // return view('payments.show_response', array(
        //     'trans' => $trans,
        //     'status' => $trans->ourstatus,
        // ));
        // return '';
        $trn = \App\Payment::find(138439)->checkStatus();
        $trn->checkStatus(true, true);
        return 'hi';

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
        if ($request->exists('merchIdVal') && $request->merchIdVal == config('services.sbipay.mer_id')) {

            // "encData" => "fe2LuBI+sp1hF1xvvRWnRDCx3DXEXd3XNSiqQXSQIP+zJlkAaoxxhAZ2om+m02FJDh7YpeVE4R3GUpd6eDQbxSLSW7NVqU/aWZWGkr/Hu5pLxgEvU8I+xgajJ+yMiomL556eraf5cCJHTAom/tFjLFcvQi/Z26/d ▶"
            // "Bank_Code" => "1000112"
            // "merchIdVal" => "1000112"

            $aesenc = new AESEnc();
            $mer_key = config('services.sbipay.mer_key');
            logger($request->all());
            // logger($response);
            $response = $aesenc->decrypt($request->encData, $mer_key);
            if (strlen($response) > 0) {
                $response = explode("|", $response);
            }
            logger($response);

            $trans = \App\Payment::whereTrcd($response[0])->firstOrFail();
            // if (!$trans) {
            //     flash('The transaction does not exist.');
            //     return redirect('stulogin');
            // }
            $trans->status = $response[2];
            // $trans->unmappedstatus = $response[];
            $trans->trid = $response[1];
            $trans->trdate1 = $response[10];
            $trans->product = $response[5];
            $trans->bank_txn = $response[9];
            $trans->msg = $response[6];
            $trans->message = $response[7];
            $trans->bank = $response[8];
            // $trans->cc_no = $response[];
            if ($response[2] === 'SUCCESS') {
                $trans->ourstatus = "OK";
                // $data = array('trans' => $trans, 'status' => 'SUC',);
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
            //      $trans->load('student', 'student.school');
        } else {
            flash('The requested page does not exist.');
            return redirect('stulogin');
        }
        // dd($request->all());
        return view('payments.show_response', array(
            'trans' => $trans,
            'status' => $trans->ourstatus,
        ));
    }

    public function pushres(Request $request)
    {
        logger("============ sbiepay push response ==============");
        logger($request->all());
        dd($request->all());
        if ($request->exists('merchIdVal') && $request->merchIdVal == config('services.sbipay.mer_id')) {

            // "encData" => "fe2LuBI+sp1hF1xvvRWnRDCx3DXEXd3XNSiqQXSQIP+zJlkAaoxxhAZ2om+m02FJDh7YpeVE4R3GUpd6eDQbxSLSW7NVqU/aWZWGkr/Hu5pLxgEvU8I+xgajJ+yMiomL556eraf5cCJHTAom/tFjLFcvQi/Z26/d ▶"
            // "Bank_Code" => "1000112"
            // "merchIdVal" => "1000112"

            $aesenc = new AESEnc();
            $mer_key = config('services.sbipay.mer_key');
            logger($request->all());
            // logger($response);
            $response = $aesenc->decrypt($request->encData, $mer_key);
            if (strlen($response) > 0) {
                $response = explode("|", $response);
            }
            logger($response);

            $trans = \App\Payment::whereTrcd($response[0])->firstOrFail();
            // if (!$trans) {
            //     flash('The transaction does not exist.');
            //     return redirect('stulogin');
            // }
            $trans->status = $response[2];
            // $trans->unmappedstatus = $response[];
            $trans->trid = $response[1];
            $trans->trdate1 = $response[10];
            $trans->product = $response[5];
            $trans->bank_txn = $response[9];
            $trans->msg = $response[6];
            $trans->message = $response[7];
            $trans->bank = $response[8];
            // $trans->cc_no = $response[];
            if ($response[2] === 'SUCCESS') {
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
        // dd($request->all());
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
