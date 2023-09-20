<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Online\Controller;
use App\Lib\AESEnc;
use App\Models\AppSetting;
use App\Payment;
use Carbon\Carbon;
use App\TransactionRequest;

class ProspectusFeeController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
    public function index()
    {
//    dd(\DB::connection(getYearlyDbConn())->getSchemaBuilder()->hasColumn('payments','std_user_id'));
//    $columns = \DB::connection(getYearlyDbConn())->getSchemaBuilder()->getColumnListing("payments");
//    dd($columns);
        $std_user = auth('students')->user();
        // $trns = Payment::incompleteTransactions($std_user->id);
        return view('payments.prospectus', [
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

    public function store(Request $request)
    {
        $app_setting= AppSetting::where('key_name','=','college_processing_fees')->first();
        // dd($app_setting);
        if($app_setting){
            $msg = $app_setting->description;
            if($app_setting->key_value == 'Close'){
                return view('errors.503', ['msg' => $msg]);
            }
        }
        // return view('errors.503', ['msg' => '']);
        $std_user = auth('students')->user();
        abort_if((!$std_user), '401', 'No authenticated student found!');

        if (Payment::incompleteTransactions($std_user->id)->count() > 0) {
            flash()->warning('There are incomplete transactions, please wait for some time.');
            return redirect()->back();
        }

        $dt = \Carbon\Carbon::now();
        $payment = new Payment();
        $payment->fill([
            'trcd' => str_random(15),
            'trn_type' => 'prospectus_fee',
            'email' => $std_user->email,
            'mobile' => $std_user->mobile,
            'amt' => config('college.payment_pros_fee'),
            'trdate' => date('mdYHis'),
            'trntime' => $dt->toDateTimeString(),
            'through' => 'sbipay',
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
                'firstname' => ($std_user->adm_form ? $std_user->adm_form->name : ''),
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
                'CUST_ID' => $payment->std_user_id,
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

        if ($payment->through == 'sbipay') {
            $trn_url = config('services.sbipay.trn_url');
            $mer_key = config('services.sbipay.mer_key');
            $mer_id = config('services.sbipay.mer_id');
            $op_mode = 'DOM';
            $country = 'IN';
            $currency = 'INR';
            $amount = $payment->amt;
            $others = "^Name: {$std_user->adm_form->name}^Email: {$payment->email}^Mobile: {$payment->mobile}";
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
