<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Events\PaymentInitiated;
use App\Jobs\CheckPmtStatus;
use App\Jobs\AddOnlineReceipt;
use Illuminate\Support\Facades\Redirect;

class Payment extends Model
{
    use Traits\ModelUtilities,
        Traits\AutoUpdateUserColumns;

    protected $table = 'payments';
    protected $guarded = ['id'];
    protected $connection = 'yearly_db';
    protected $hidden = [
        'cc_no'
    ];
    protected $events = [
        'created' => PaymentInitiated::class
    ];

    public function checkStatus($show = false, $force = false, $pending = true)
    {
        $ourstatus = $this->ourstatus;
        if ($this->ourstatus == 'OK' && $force == false) {
            return $this;
        }
        if ($this->through == 'atom') {
            $resp = $this->checkStatusAtom($show, $force, $pending);
        } elseif ($this->through == 'paytm') {
            $resp = $this->checkStatusPaytm($show, $force);
        } elseif ($this->through == 'payu') {
            $resp = $this->checkStatusPayU($show);
        } elseif ($this->through == 'sbipay') {
            $resp = $this->checkStatusSbipay($show, $force);
        }

        if ($this->ourstatus == 'OK' && $this->ourstatus != $ourstatus) {
            $job = (new AddOnlineReceipt($this))->delay(Carbon::now()->addSeconds(2));
            dispatch($job);
        }
        return $resp;
    }

    public static function incompleteTransactions($std_user_id, $alumni_user = false)
    {
        if (env('APP_ENV', 'production') == 'local') {
            $dt_from = Carbon::now()->subSeconds(config('college.payment_trn_wait', 2));
        } else {
            $dt_from = Carbon::now()->subMinutes(config('college.payment_trn_wait', 10));
        }

        if (!$alumni_user) {
            return static::where('std_user_id', '=', $std_user_id)
                ->where('status', '=', '')
                ->where('created_at', '>', $dt_from)->get();
        }

        return static::where('alumni_user_id', '=', $std_user_id)
            ->where('status', '=', '')
            ->where('created_at', '>', $dt_from)->get();
    }

    public function checkStatusPayU($show = false)
    {
        // if (trim($gate) == '') {
        //     $gate = $this->student->school->gateway;
        // }
        $qryurl = config("college.payu.qryurl");
        $key = config('college.payu.key');
        $salt = config('college.payu.salt');
        $command = 'verify_payment';
        $var1 = $this->trcd;
        $hash = hash('sha512', "$key|$command|$var1|$salt");
        $client = new \GuzzleHttp\Client();
        $response = $client->post($qryurl, [
            'form_params' => [
                'merchantKey' => $key,
                'merchantTransactionIds' => $this->trcd,
            ],
            'headers' => [
                'authorization' => config('college.payu.auth_header'),
                'cache-control' => 'no-cache'
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            if (app()->runningInConsole()) {
                return false;
            } else {
                return Redirect::back();
            }
        }
        // dd($response->getStatusCode());
        $data = json_decode($response->getBody()->getContents(), true);
        if ($show) {
            dd($data);
        }
        Log::info($data);
        // return $data;
        // Log::info('done');
        if (data_get($data, 'status', -1) == 0) {
            $this->message = data_get($data, 'message', 'NA');
            if (data_get($data, 'result.0.merchantTransactionId') == $this->trcd && data_get($data, 'result.0.postBackParam')) {
                $data = data_get($data, 'result.0.postBackParam');
                if ($data['status'] === 'success') {
                    $this->ourstatus = "OK";
                    // $std_user = \App\StudentUser::find($this->std_user_id);
                    // if ($this->trn_type == 'admission_fee' && $this->fee_rcpt_id == 0) {
                    //     $fee_rcpt_id = $std_user->admitStudent();
                    //     $this->fee_rcpt_id = $fee_rcpt_id;
                    // }
                    // $this->addReceipt();
                } else {
                    $this->ourstatus = "FAL";
                }
                $this->status = $data['status'];
                $this->unmappedstatus = $data['unmappedstatus'];
                $this->trid = $data['payuMoneyId'];
                $this->trdate1 = $data['addedon'];
                $this->product = $data['mode'];
                $this->bank_txn = $data['pg_TYPE'];
                //$this->clientcode = $data['mihpayid'];
                $this->save();
            }
        } else {
            // dd($data);
            // $data = $data['transaction_details'][$var1];
            $this->message = data_get($data, 'message', 'NA');
            $data = data_get($data, 'result.0.postBackParam');
            $this->ourstatus = "NA";
            $this->status = data_get($data, 'status');
            $this->trid = data_get($data, 'mihpayid');
            $this->save();
        }
        return $this;
    }

    public function checkStatusSbipay($show = false, $force = false)
    {
        if ($this->ourstatus == 'OK' && $force == false) {
            return $this;
        }

        $qryurl = config("services.sbipay.qryurl");
        $mer_key = config('services.sbipay.mer_key');
        $mer_id = config('services.sbipay.mer_id');
        $command = 'verify_payment';
        $var1 = $this->trcd;
        $data = "|{$mer_id}|{$this->trcd}|{$this->amt}";

        $client = new \GuzzleHttp\Client();
        // dd($mer_id);

        try {
            $response = $client->post($qryurl, [
                'form_params' => [
                    'queryRequest' => $data,
                    'aggregatorId' => 'SBIEPAY',
                    'merchantId' => $mer_id
                ],
            ]);
        } catch (\Exception $e) {
            Log::info("----------------- Trcd: {$this->trcd} --------------------------");
            // dd($e);
            Log::info($e->getMessage());
            $job = (new CheckPmtStatus($this))->delay(Carbon::now()->addMinutes(2));
            dispatch($job);
            return $this;
        }

        // logger($response->getBody()->getContents());
        if ($response->getStatusCode() != 200) {
            if (app()->runningInConsole()) {
                return false;
            } else {
                return Redirect::back();
            }
        }

        $data = $response->getBody()->getContents();
        $data = explode("|", $data);

        if ($show) {
            dd($data);
        }
        logger("========== transaction check " . $this->id . "=============");
        Log::info($data);
        // return $data;
        // Log::info('done');
        if ($data && $data[2]) {
            if ($data[2] === 'SUCCESS') {
                $this->ourstatus = "OK";
                $this->msg = $data[6];
                $this->bank = $data[8];
                // $std_user = \App\StudentUser::find($this->std_user_id);
                // if ($this->trn_type == 'admission_fee' && $this->fee_rcpt_id == 0) {
                //     $fee_rcpt_id = $std_user->admitStudent();
                //     $this->fee_rcpt_id = $fee_rcpt_id;
                // }
                // $this->addReceipt();
            } else {
                $this->ourstatus = "FAL";
            }
            $this->message = $data[7];
            $this->status = $data[2];
            $this->trid = $data[1];
            $this->trdate1 = $data[10];
            $this->product = $data[5];
            $this->bank_txn = $data[9];
            //$this->clientcode = $data['mihpayid'];
            $this->save();
            // if ($data[2] == 'PENDING' || $data[2] == 'INPROGRESS') {
            //     $job = (new CheckPmtStatus($this))->delay(Carbon::now()->addHours(3));
            //     dispatch($job);
            // }
        } else {
            $this->message = 'NA';
            $this->ourstatus = "NA";
            $this->status = 'Not Found';
            $this->trid = '';
            $this->save();
        }
        return $this;
    }

    public function checkStatusPaytm($show = false, $force = false)
    {
        if ($this->ourstatus == 'OK' && $force == false) {
            return $this;
        }
        $data = [
            "MID" => config('services.paytm.mid'),
            "ORDERID" => $this->trcd,
        ];
        $data["CHECKSUMHASH"] = getChecksumFromArray($data, config('services.paytm.merchant_key'));
        $client = new \GuzzleHttp\Client();
        $qryurl = config('services.paytm.qryurl');

        $JsonData = json_encode($data);
        $postData = 'JsonData=' . urlencode($JsonData);

        try {
            $response = $client->post($qryurl, [
                'body' => $postData,
                'headers' => [
                    'Content-Type' => 'application/json',
                    // 'cache-control' => 'no-cache'
                ],
                'verify' => false
            ]);
        } catch (\Exception $e) {
            Log::info("----------------- Trcd: {$this->trcd} --------------------------");
            // dd($e);
            Log::info($e->getMessage());
            $job = (new CheckPmtStatus($this))->delay(Carbon::now()->addMinutes(2));
            dispatch($job);
            return $this;
        }

        if ($response->getStatusCode() != 200) {
            if (app()->runningInConsole()) {
                return false;
            } else {
                return Redirect::back();
            }
        }
        // dd($response->getStatusCode());
        $data = json_decode($response->getBody()->getContents(), true);
        if ($show) {
            dd($data);
        }
        Log::info($data);
        // return $data;
        // Log::info('done');
        if (data_get($data, 'STATUS')) {
            $this->status = $data['STATUS'];
            $this->unmappedstatus = ''; // $request->unmappedstatus;
            $this->trid = $data['TXNID'];
            $this->cc_no = ''; //$request->cardnum;
            $this->resp_code = $data['RESPCODE'];
            $this->message = $data['RESPMSG'];
            if ($data['STATUS'] === 'TXN_SUCCESS') {
                $this->trdate1 = $data['TXNDATE'];
                $this->product = $data['PAYMENTMODE'];
                $this->bank_txn = $data['GATEWAYNAME'];
                $this->bank = data_get($data, 'BANKNAME', '');
                $this->ourstatus = "OK";
                $data = array('trans' => $this, 'status' => 'SUC',);
                // Mail::send(array('html' => 'emails.payutrn'), $data, function ($message) use ($this) {
                //     $message->to($this->email, $this->student->StdName)->subject('Transaction was Successful!');
                // });
                // $this->addReceipt();
            } else {
                $this->ourstatus = "FAL";
            }
            $this->save();
            if (strpos(strtoupper($this->status), 'PENDING') !== false) {
                $job = (new CheckPmtStatus($this))->delay(Carbon::now()->addHours(3));
                dispatch($job);
            }
        } else {
            // dd($data);
            // $data = $data['transaction_details'][$var1];
            $this->message = 'NA';
            $this->ourstatus = "NA";
            $this->status = 'Not Found';
            $this->trid = '';
            $this->save();
        }
        return $this;
    }

    public function addReceipt()
    {
        if ($this->ourstatus != 'OK') {
            return false;
        }
        logger('----------------------------running addReceipt----------------------------------------');
        // if ($this->alumni_user_id > 0) {
        //     return false;
        // }
        if ($this->fee_rcpt_id == 0) {
            if (!$this->fee_rcpt) {
                if ($this->alumni_user_id == 0) {
                    $std_user = StudentUser::find($this->std_user_id);
                    $student = Student::find($this->std_id);
                    $outsider = Outsider::find($this->outsider_id);
                    $fee_rcpt_id = 0;
                    if ($this->trn_type == 'admission_fee' && $this->fee_rcpt_id == 0) {
                        $fee_rcpt_id = $std_user->admitStudent($this->id);
                    }
                    if ($this->trn_type == 'college_receipt' && $this->fee_rcpt_id == 0) {
                        $fee_rcpt_id = $std_user->receivePayment('C', $this->id);
                    }
                    if ($this->trn_type == 'hostel_receipt' && $this->fee_rcpt_id == 0) {
                        $fee_rcpt_id = $std_user->receivePayment('H', $this->id);
                    }
                    if (($this->trn_type == 'direct_college_receipt' || $this->trn_type == 'direct_hostel_receipt') && $this->fee_rcpt_id == 0) {
                        if ($student) {
                            $fee_rcpt_id = $student->receivePayment($this->fund, $this->last_fee_bill_id, $this->id);
                        } elseif ($outsider) {
                            $fee_rcpt_id = $outsider->receivePayment($this->fund, $this->last_fee_bill_id, $this->id);
                        }
                    }
                    $this->fee_rcpt_id = $fee_rcpt_id;
                    Log::info('receipt not exist!');
                }
            } else {
                Log::info('receipt exists!');
                $this->fee_rcpt_id = $this->fee_rcpt->id;
            }
            $this->save();

            if ($this->trn_type == 'alumni_life_fee') {
                $alumni_user = AlumniUser::findOrFail($this->alumni_user_id);
                $alumni = AlumniStudent::whereAlumniUserId($alumni_user->id)->first();
                logger($alumni);
                if ($alumni->life_member == 'N') {
                    $alumni->life_member = 'Y';
                    $alumni->save();
                }
            }
        }
    }

    public function checkStatusMulti($coll)
    {
        //    if (trim($gate) == '') {
        //      $gate = $this->student->school->gateway;
        //    }
        $qryurl = config("college.payu.qryurl");
        $key = config('college.payu.key');
        $salt = config('college.payu.salt');
        $command = 'verify_payment';
        $var1 = $this->trcd;
        $hash = hash('sha512', "$key|$command|$var1|$salt");
        $client = new \GuzzleHttp\Client();
        $response = $client->post($qryurl, [
            'form_params' => [
                'merchantKey' => $key,
                'merchantTransactionIds' => $this->trcd,
            ],
            'headers' => [
                'authorization' => config('college.payu.auth_header'),
                'cache-control' => 'no-cache'
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            return Redirect::back();
        }
        //    dd($response->getStatusCode());
        $data = json_decode($response->getBody()->getContents(), true);
        //    dd($data);
        if (data_get($data, 'status', -1) == 0) {
            $this->message = data_get($data, 'message', 'NA');
            if (data_get($data, 'result.0.merchantTransactionId') == $this->trcd && data_get($data, 'result.0.postBackParam')) {
                $data = data_get($data, 'result.0.postBackParam');
                if ($data['status'] === 'success') {
                    $this->ourstatus = "OK";
                } else {
                    $this->ourstatus = "FAL";
                }
                $this->status = $data['status'];
                $this->unmappedstatus = $data['unmappedstatus'];
                $this->trid = $data['mihpayid'];
                $this->trdate1 = $data['addedon'];
                $this->product = $data['mode'];
                $this->bank_txn = $data['pg_TYPE'];
                //$this->clientcode = $data['mihpayid'];
                $this->save();
            }
        } else {
            //      dd($data);
            //      $data = $data['transaction_details'][$var1];
            $this->message = data_get($data, 'message', 'NA');
            $data = data_get($data, 'result.0.postBackParam');
            $this->ourstatus = "NA";
            $this->status = data_get($data, 'status');
            $this->trid = data_get($data, 'mihpayid');
            $this->save();
        }
        return $this;
    }

    public function checkStatusAtom($show = false, $force = false, $pending = true)
    {
        if ($this->ourstatus == 'OK' && $force == false) {
            return $this;
        }
        $qryurl = config("services.atom.qryurl");
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->post($qryurl, [
                'form_params' => [
                    'merchantid' => config("services.atom.login"),
                    'merchanttxnid' => $this->trcd,
                    'amt' => $this->amt + $this->fine + $this->comm,
                    'tdate' => Carbon::parse($this->trntime)->toDateString()
                ],
                // 'verify' => false
            ]);
        } catch (\Exception $e) {
            Log::info("----------------- Trcd: {$this->trcd} --------------------------");
            // dd($e);
            Log::info($e->getMessage());
            $job = (new CheckPmtStatus($this))->delay(Carbon::now()->addMinutes(2));
            dispatch($job);
            return $this;
        }
        if ($response->getStatusCode() != 200) {
            if (app()->runningInConsole()) {
                return false;
            } else {
                return Redirect::back();
            }
        }
        // dd($response->getBody()->getContents());
        // dd(simplexml_load_string($response->body));
        $values = xmltoarray($response->getBody()->getContents());
        $data = $values[0]['attributes'];
        if ($show) {
            dd($data);
        }
        Log::info($data);
        // dd($values);
        // dd($data);
        // if ($data['VERIFIED'] == 'SUCCESS' || $data['VERIFIED'] == 'FAILED' || $data['VERIFIED'] == 'NODATA') {
        if ($data['VERIFIED'] == 'SUCCESS') {
            // if ($this->ourstatus == 'OK' && $force == false) {
            //     return $this;
            // }
            $this->status = 'Ok';
            $this->ourstatus = "OK";
        } elseif ($data['VERIFIED'] == 'FAILED') {
            $this->status = 'F';
            $this->ourstatus = "FAL";
        } else {
            $this->status = $data['VERIFIED'];
            $this->ourstatus = "FAL";
        }
        if ($data['VERIFIED'] != 'Invalid date format') {
            $this->unmappedstatus = ''; //in case of payu $inputs['unmappedstatus'];
            $this->trid = $data['atomtxnId'];
            $this->trdate1 = $data['TxnDate'];
            if ($this->trdate1 != 'null' && $this->trdate1 != '') {
                $this->trdate2 = Carbon::parse($this->trdate1)->toDateTimeString();
            }
            $this->product = $data['discriminator'];
            $this->bank_txn = $data['BID'];
            $this->bank = $data['bankname'];
            $this->cc_no = $data['CardNumber'];
        }
        $this->save();
        // }
        // if (strpos(strtoupper($this->status), 'INITIATED') !== false) {
        //     $job = (new CheckPmtStatus($this))->delay(Carbon::now()->addMinutes(10));
        //     dispatch($job);
        // }
        if (strpos(strtoupper($this->status), 'PENDING') !== false && $pending == true) {
            $job = (new CheckPmtStatus($this))->delay(Carbon::now()->addHours(3));
            dispatch($job);
        }
        return $data;
    }

    public function saveAttributes()
    {
        if (auth('students')->user()) {
            $this->std_user_id = auth('students')->user()->id;
        }
    }

    public function fee_rcpt()
    {
        return $this->hasOne(FeeRcpt::class, 'payment_id', 'id');
    }

    public function std_user()
    {
        return $this->belongsTo(StudentUser::class, 'std_user_id', 'id');
    }

    public function initiatedBefore()
    {
        return $this->created_at->diffInMinutes(Carbon::now());
    }
}
