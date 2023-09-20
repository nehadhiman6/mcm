<?php

namespace App\Http\Controllers\Payments;

use App\FeeBill;
use App\Payment;
use Illuminate\Http\Request;
// use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Online\Controller;
use App\Lib\AESEnc;
use App\Models\AppSetting;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Student;
use App\TransactionRequest;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    use ValidatesRequests;

    protected $fund_type = 'C';

    protected $msg = '';
    protected $app_setting = '';

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->app_setting = AppSetting::where('key_name', '=', 'pay_college_dues')->first();
        if ($this->app_setting) {
            $this->msg = $this->app_setting->description;
        }

        // $this->msg = 'Deposit your exam. fee at Punjab University and then inform the college examination branch.';
        // $this->msg = 'Be right back.';
        // $this->msg = 'The dashboard will be available for depositing fees from 10th March 2022';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->app_setting->key_value == 'Close') {
            return view('errors.503', ['msg' => $this->msg]);
        }

        $fund_type = $this->fund_type;
        if (!request()->ajax()) {
            if (auth('students')->check() && auth()->user()->student) {
                return View('payments.pay_dues_direct', compact('fund_type'));
            } else {
                flash()->warning('Nothing to do!');
                return View('online.dashboard');
            }
        }

        $this->validate($request, [
            'adm_no' => 'required|exists:' . getYearlyDbConn() . '.students,adm_no'
        ]);
        $student = \App\Student::where('adm_no', '=', $request->adm_no)
            ->with('course')->firstOrFail();

        $pend_bal = $student->getPendingFeeDetails();
        if ($pend_bal->count() == 0) {
            return response()
                ->json(['no_balance' => ['No dues!!']], 422, ['app-status' => 'error']);
        }

        $last_fbid = getLastFeeBillID();

        return compact('student', 'pend_bal', 'last_fbid') + ['fund_type' => $this->fund_type];
    }

    // public function create()
    // {
    //     dd('here');
    //     $sms = new \App\Lib\Sms();
    //     $a = $sms->send('Testing Hello', '9216800973');
    //     var_dump($a);
    //     dd('here');
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->app_setting->key_value == 'Close') {
            return view('errors.503', ['msg' => $this->msg]);
        }
        $std_user = auth('students')->user();
        abort_if((!$std_user), '401', 'No authenticated student found!');

        // $student = Student::whereAdmNo($request->adm_no)->first();
        $student = $std_user->student;
        // dd($student);
        if (!$student) {
            $rules = ['admitted' => "required"];
            $messages = ['admitted.required' => "No student found with the given admission number!"];
            $this->validate($request, $rules, $messages);
        }

        if (Payment::incompleteTransactions($std_user->id)->count() > 0) {
            flash()->warning('There are incomplete transactions, please wait for some time.');
            return redirect()->back();
        }

        $dt = \Carbon\Carbon::now();
        $payment = new \App\Payment();
        $payment->fill([
            'trcd' => str_random(15),
            'trn_type' => 'direct_college_receipt',
            'std_id' => $student->id,
            'email' => $student->std_user->email,
            'mobile' => $student->std_user->mobile,
            'amt' => $request->amount,
            'trdate' => date('mdYHis'),
            'trntime' => $dt->toDateTimeString(),
            'through' => 'sbipay',
        ]);
        $payment->std_user_id = 0;
        $payment->last_fee_bill_id = $request->last_fbid;
        $payment->save();

        if ($payment->through == 'sbipay') {
            $trn_url = config('services.sbipay.trn_url');
            $mer_key = config('services.sbipay.mer_key');
            $mer_id = config('services.sbipay.mer_id');
            $op_mode = 'DOM';
            $country = 'IN';
            $currency = 'INR';
            $amount = $payment->amt;
            $others = "^Name: {$student->name}^Email: {$payment->email}^Mobile: {$payment->mobile}";
            $surl = action('Payments\SbiPayTransController@store');
            $furl = action('Payments\SbiPayTransController@store');
            $agg_id = 'SBIEPAY';
            $order_no = $payment->trcd;
            $cust_id = 'NA';
            $paymode = 'NB';
            $medium = 'ONLINE';
            $source = 'ONLINE';

            $aesenc = new AESEnc();

            $data = "{$mer_id}|{$op_mode}|{$country}|{$currency}|{$amount}|{$others}|{$surl}|{$furl}|{$agg_id}|{$order_no}|{$cust_id}|{$paymode}|{$medium}|{$source}";
            // dd($data);

            $encrypt_trans = $aesenc->encrypt($data, $mer_key);
            return view('trans.sbipay_trn', array(
                'encrypt_trans' => $encrypt_trans,
                'mer_id' => $mer_id
            ));
        }

        if ($payment->through == 'payu') {
            $data = array(
                'trnurl' => config('college.payu.trnurl'),
                'key' => config('college.payu.key'),
                'salt' => config('college.payu.salt'),
                'txnid' => $payment->trcd,
                'amount' => $payment->amt,
                'productinfo' => 'SGGS Prospectus Fees',
                'firstname' => $student->name,
                'email' => $payment->email,
                'phone' => $payment->mobile,
                'surl' => action('Payments\TransController@store'),
                'furl' => action('Payments\TransController@store'),
                'service_provider' => 'payu_paisa'
            );
            //    dd($data);
            $data['hash'] = hash('sha512', "$data[key]|$data[txnid]|$data[amount]|$data[productinfo]|$data[firstname]|$data[email]|||||||||||$data[salt]");
            return view('trans.payu_trn', array(
                'data' => $data,
            ));
        }

        if ($payment->through == 'paytm') {
            $data = [
                'REQUEST_TYPE' => 'DEFAULT',
                'MID' => config('services.paytm.mid'),
                'ORDER_ID' => $payment->trcd,
                'CUST_ID' => $student->adm_no,
                'TXN_AMOUNT' => $payment->amt,
                'CHANNEL_ID' => 'WEB',
                'INDUSTRY_TYPE_ID' => config('services.paytm.ind_type_id'),
                'WEBSITE' => config('services.paytm.website'),
                'CALLBACK_URL' => url('paytmtrans'),
                'MOBILE_NO' => $payment->mobile,
                'EMAIL' => $payment->email,
            ];
            $checkSum = getChecksumFromArray($data, config('services.paytm.merchant_key'));
            Log::info($checkSum);

            return view('trans.paytm_trn', compact('data', 'checkSum'));
        }

        if ($payment->through == 'atom') {
            $data = array(
                'trnurl' => config("services.atom.trnurl"),
                'login' => config("services.atom.login"),
                'pass' => config("services.atom.pass"),
                'ttype' => 'NBFundTransfer',
                'prodid' => config("services.atom.prodid"),
                'amt' => $payment->amt,
                'txncurr' => 'INR',
                'txnscamt' => 0,
                'clientcode' => '007',
                'txnid' => $payment->trcd,
                'date' => $dt->format('d/m/Y H:i:s'), //'DD/MM/YYYY HH:MM:SS'
                'custacc' => $std_user->id,
                'udf1' => ($std_user->adm_form ? $std_user->adm_form->name : ''),
                'udf2' => $payment->email,
                'udf3' => $payment->mobile,
                'udf4' => 'address',
                'ru' => url('atomtrans')
            );

            // dd($data);
            //

            $str = $data['login'] . $data['pass'] . "NBFundTransfer" . $data['prodid'] . $data['txnid'] . $data['amt'] . "INR";
            // echo $str;exit;
            $signature =  hash_hmac("sha512", $str, config("services.atom.req_hash_key"), false);

            $transactionRequest = new TransactionRequest();

            //Setting all values here
            $transactionRequest->setMode(config("college.atom.mode"));
            $transactionRequest->setLogin($data['login']);
            $transactionRequest->setPassword($data['pass']);
            $transactionRequest->setProductId($data['prodid']);
            $transactionRequest->setAmount($data['amt']);
            $transactionRequest->setTransactionCurrency("INR");
            $transactionRequest->setTransactionAmount($data['amt']);
            $transactionRequest->setReturnUrl($data['ru']);
            $transactionRequest->setClientCode(config('client_code'));
            $transactionRequest->setTransactionId($data['txnid']);
            $transactionRequest->setTransactionDate($data['date']);
            $transactionRequest->setCustomerName($std_user->adm_form ? $std_user->adm_form->name : '');
            $transactionRequest->setCustomerEmailId($payment->email);
            $transactionRequest->setCustomerMobile($payment->mobile);
            $transactionRequest->setCustomerBillingAddress("Chandigarh");
            $transactionRequest->setCustomerAccount($std_user->id);
            $transactionRequest->setReqHashKey(config("services.atom.req_hash_key"));


            $url = $transactionRequest->getPGUrl();
            // dd($url);
            header("Location: $url");
            die('');

            $qryurl = config("college.atom.trnurl");

            //    $curl = new anlutro\cURL\cURL;
            $client = new \GuzzleHttp\Client();
            $response = $client->get($qryurl, [
                'verify' => false,
                'query' => [
                    'login' => $data['login'],
                    'pass' => $data['pass'],
                    'ttype' => $data['ttype'],
                    'prodid' => $data['prodid'],
                    'amt' => $data['amt'],
                    'txncurr' => $data['txncurr'],
                    'txnscamt' => $data['txnscamt'],
                    'clientcode' => $data['clientcode'],
                    'txnid' => $data['txnid'],
                    'date' => $data['date'],
                    'custacc' => $data['custacc'],
                    'udf1' => $data['udf1'],
                    'udf2' => $data['udf2'],
                    'udf3' => $data['udf3'],
                    'udf4' => $data['udf4'],
                    'ru' => $data['ru'],
                    'signature' => $signature
                ],
            ]);
            // dd($response);
            if ($response->getStatusCode() != 200) {
                return Redirect::back();
            }
            // $data = unserialize($response->getBody()->getContents());
            // dd($data);
            dd($response->getBody()->getContents());
            $atom_response = simplexml_load_string($response->getBody()->getContents())->MERCHANT->RESPONSE;
            //    var_dump($response->body);
            //    var_dump($atom_response);
            //    var_dump($atom_response->url);
            //    var_dump($atom_response->param[0]);
            //    var_dump($atom_response->param[1]);
            //    var_dump($atom_response->param[2]);
            //    var_dump($atom_response->param[3]);
            //    dd('here');
            $url = $atom_response->url;
            $postFields = "";
            $postFields .= "&ttype=" . $atom_response->param[0];
            $postFields .= "&tempTxnId=" . $atom_response->param[1];
            $postFields .= "&token=" . $atom_response->param[2];
            $postFields .= "&txnStage=" . $atom_response->param[3];
            $url .= "?" . $postFields;
            header("Location: " . $url);
            dd('here');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
