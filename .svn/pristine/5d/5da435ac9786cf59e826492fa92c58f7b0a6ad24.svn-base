<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Alumni\Controller;
use App\Payment;
use Carbon\Carbon;
use App\TransactionRequest;

class AlumniMeetFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alumni_user = auth('alumnies')->user();
        // $trns = Payment::incompleteTransactions($alumni_user->id);
        return view('payments.alumni_meet_fee', [
            'fees_for' => 'college',
            // 'trns' => $trns
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
        $alumni_user = auth('alumnies')->user();
        abort_if((!$alumni_user), '401', 'No authenticated student found!');

        if (Payment::incompleteTransactions($alumni_user->id)->count() > 0) {
            flash()->warning('There are incomplete transactions, please wait for some time.');
            return redirect()->back();
        }

        $dt = \Carbon\Carbon::now();
        $payment = new Payment();
        $payment->fill([
            'trcd' => str_random(15),
            'alumni_user_id' => $alumni_user->id,
            'trn_type' => 'alumni_meet_fee',
            'email' => $alumni_user->email,
            'mobile' => $alumni_user->almForm->mobile,
            'amt' => config('college.alumni_meet_fee'),
            'trdate' => date('mdYHis'),
            'trntime' => $dt->toDateTimeString(),
            'through' => 'atom',
        ]);
        $payment->save();

        if ($payment->through == 'payu') {
            $data = array(
                'trnurl' => config('college.payu.trnurl'),
                'key' => config('college.payu.key'),
                'salt' => config('college.payu.salt'),
                'txnid' => $payment->trcd,
                'amount' => $payment->amt,
                'productinfo' => 'SGGS Prospectus Fees',
                'firstname' => $alumni_user->name,
                'email' => $payment->email,
                'phone' => $payment->mobile,
                'surl' => action('Payments\TransController@store'),
                'furl' => action('Payments\TransController@store'),
                'service_provider' => 'payu_paisa'
            );
            //    dd($data);
            $data['hash'] = hash('sha512', "$data[key]|$data[txnid]|$data[amount]|$data[productinfo]|$data[firstname]|$data[email]|||||||||||$data[salt]");
            //    var_dump($data['hash']);


            return view('trans.payu_trn', array(
                'data' => $data,
            ));
        }

        if ($payment->through == 'paytm') {
            $data = [
                'REQUEST_TYPE' => 'DEFAULT',
                'MID' => config('services.paytm.mid'),
                'ORDER_ID' => $payment->trcd,
                'CUST_ID' => $payment->alumni_user_id,
                'TXN_AMOUNT' => $payment->amt,
                'CHANNEL_ID' => 'WEB',
                'INDUSTRY_TYPE_ID' => config('services.paytm.ind_type_id'),
                'WEBSITE' => config('services.paytm.website'),
                'CALLBACK_URL' => url('paytmtrans'),
                'MOBILE_NO' => $payment->mobile,
                'EMAIL' => $payment->email,
            ];
            $checkSum = getChecksumFromArray($data, config('services.paytm.merchant_key'));

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
                'custacc' => $alumni_user->id,
                'udf1' => $alumni_user->name,
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
            $transactionRequest->setCustomerName($alumni_user->name);
            $transactionRequest->setCustomerEmailId($payment->email);
            $transactionRequest->setCustomerMobile($payment->mobile);
            $transactionRequest->setCustomerBillingAddress("Chandigarh");
            $transactionRequest->setCustomerAccount($alumni_user->id);
            $transactionRequest->setReqHashKey(config("services.atom.req_hash_key"));


            $url = $transactionRequest->getPGUrl();
            // dd($url);
            header("Location: $url");
            die('');
        }
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
    public function feeStatus()
    {
        $alumni_payments = \App\Payment::where('alumni_user_id', auth('alumnies')->user()->id)
            // ->where('ourstatus', '=', 'OK')
            ->orderBy('trntime', 'desc');
        if (auth('alumnies')->user()->almForm) {
            $alumni_payments = $alumni_payments->orWhere('alumni_user_id', auth('alumnies')->user()->almForm->id);
        }
        $std_payments = $alumni_payments->get();
        return view('alumni.alumnipayments', compact('std_payments'));
    }
}
