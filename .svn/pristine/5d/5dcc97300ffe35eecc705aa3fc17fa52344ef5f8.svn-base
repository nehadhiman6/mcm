<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
// use App\Http\Controllers\Online\Controller;
use DB;
use Carbon\Carbon;
use App\Payment;
use App\TransactionRequest;
use App\SubjectCharge;
use App\SubFeeHead;
use App\AdmissionEntry;
use App\AdmissionForm;
use App\Http\Controllers\Online\Controller;
use App\Lib\AESEnc;
use App\Models\AppSetting;

class PayAdmissionFeeController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd(auth('students')->user()->id);
        $std_user = auth('students')->user();
        abort_if((!$std_user), '401', 'No authenticated student found!');
        $final_submission = \App\AdmissionForm::where('std_user_id',$std_user->id)->first()->final_submission;
        if($final_submission == 'N'){
            $msg = 'Your Final Submission is Still Pending !';
            return view('errors.503', ['msg' => $msg]);
        }
        $app_setting= AppSetting::where('key_name','=','pay_add_fees')->first();
        // dd($app_setting);
        if($app_setting){
            $msg = $app_setting->description;
            if($app_setting->key_value == 'Close'){
                return view('errors.503', ['msg' => $msg]);
            }
        }
        $subheads = SubFeeHead::with(['feehead'])->get();
        if (!request()->ajax()) {
            // $std_user = auth('students')->user() ?: null;
            $std_user = auth('students')->user();
            $adm_form = null;
            if ($std_user) {
                $adm_form = $std_user->adm_form;

                if (Payment::incompleteTransactions($std_user->id)->count() > 0) {
                    flash()->warning('There are incomplete transactions, please wait for some time.');
                    return redirect()->back();
                }
            }

            return view('online.payadmfees.create', compact('subheads', 'adm_form'));
        }
        $messages = [];
        $student_det = \App\AdmissionForm::where('id', '=', $request->form_no)
            ->with('course')->select('id', 'name', 'father_name', 'course_id', 'adm_entry_id', 'status', 'conveyance', 'foreign_national', 'migration','mcm_graduate')->first();
        if ($student_det) {
            $rules = [
                'form_no' => 'required|exists:' . getYearlyDbConn() . '.admission_entries,admission_id',
            ];
            $messages = [
                'form_no.exists' => 'No Admission Entry Found For This Form No.Update Admission Entry Before Admission.'
            ];
            $adm_entry = $student_det->admEntry;
            if ($student_det && $student_det->status == 'A') {
                $rules['adm_no'] = 'required';
                $messages += [
                    'adm_no.required' => 'Student is already admitted!!'
                ];
            }
            if ($adm_entry) {
                //condition for vlidity till 12 PM (in the noon)
                // if (Carbon::today()->diffInHours(Carbon::createFromFormat('d-m-Y', $adm_entry->valid_till)->setTime(12, 0, 0), false) < 0) {
                if (Carbon::now()->diffInMinutes(Carbon::createFromFormat('d-m-Y H:i:s', $adm_entry->valid_till . " 23:59:00"), false) < 0) {
                    $rules['entry-date'] = 'required';
                }
                $messages += [
                    'entry-date.required' => 'Admission Entry was valid till ' . $adm_entry->valid_till . " mid night",
                ];
            }
        } else {
            $rules = [
                'form_no' => 'required|exists:' . getYearlyDbConn() . '.admission_forms,id',
            ];
        }
        //    dd($rules);
        $this->validate($request, $rules, $messages);
        $fee_str = $student_det->getAdmFeeStr();
        $misc_charges = $student_det->getMiscCharges();
        $other_charges = $student_det->getOtherCharges();

        return compact('student_det', 'fee_str', 'adm_entry', 'misc_charges', 'subheads', 'other_charges') + ['installment_id' => 1];


        // $fee_str = \App\FeeStructure::join('sub_heads', 'sub_heads.id', '=', 'fee_structures.subhead_id')
        //     ->join('fee_heads', 'fee_heads.id', '=', 'sub_heads.feehead_id')
        //     ->orderBy('fee_heads.name')
        //     ->whereCourseId($student_det->course_id)
        //     ->whereStdTypeId($adm_entry->std_type_id)->whereInstallmentId(1)
        //     ->where('fee_structures.optional', '=', 'N')
        //     ->select(DB::raw("fee_heads.name as feehead, sum(fee_structures.amount) as amount"))
        //     ->groupBy('fee_heads.name')->get();
        // $misc_charges = [];
        // $pract_ids = $student_det->admSubs()->join('course_subject', 'admission_subs.subject_id', '=', 'course_subject.subject_id')
        //     ->where('course_subject.practical', '=', 'Y')
        //     ->where('course_subject.course_id', '=', $student_det->course_id)
        //     ->get(['admission_subs.subject_id'])->pluck('subject_id')->toArray();
        // $pract_ids += [ $adm_entry->addon_course_id, $adm_entry->honour_sub_id ];
        // $misc_charges = SubjectCharge::join(getSharedDb() . 'subjects', 'subjects.id', '=', 'subject_charges.subject_id')
        //         ->where('course_id', '=', $student_det->course_id)
        //         ->whereIn('subject_id', $pract_ids)
        //         ->select(['subjects.subject', 'subject_charges.*'])
        //         // ->select(['subjects.subject', 'subject_charges.pract_fee', 'subject_charges.pract_exam_fee', 'subject_charges.hon_fee', 'subject_charges.hon_exam_fee'])
        //         ->get();
        // $other_charges = [];
        // if ($adm_entry->addon_course_id > 0) {
        //     $other_charges[] = [
        //         'name' => 'ADD ON COURSE (' . $adm_entry->add_on_course->course_name . ')',
        //         'charges' => config('college.add_on_fee'),
        //         'sh_id' => config('college.addon_sh_id')
        //     ];
        // }
        // if ($student_det->conveyance == 'Y') {
        //     $other_charges[] = [
        //         'name' => 'CONVEYANCE CHARGES',
        //         'charges' => config('college.parking_fee'),
        //         'sh_id' => config('college.parking_sh_id')
        //     ];
        // }
        // if ($adm_entry->std_type_id == 1 && $student_det->foreign_national == 'Y') {
        //     $other_charges[] = [
        //         'name' => 'FOREIGN FEES',
        //         'charges' => config('college.foreign_fee'),
        //         'sh_id' => config('college.foreign_sh_id')
        //     ];
        // }
        // if ($adm_entry->std_type_id == 1 && $student_det->migration == 'Y') {
        //     $other_charges[] = [
        //         'name' => 'MIGRATION FEES',
        //         'charges' => config('college.mig_fee'),
        //         'sh_id' => config('college.mig_sh_id')
        //     ];
        // }
        // // dd($other_charges);

        // return compact('student_det', 'fee_str', 'adm_entry', 'misc_charges', 'subheads', 'other_charges', 'pract_ids') + ['installment_id' => 1];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if (auth('students')->user()) {
            $std_user = auth('students')->user();
            abort_if((!$std_user), '401', 'No authenticated student found!');
            $adm_form = $std_user->adm_form;
        } else {
            $adm_form = AdmissionForm::findOrFail($request->form_no);
            $std_user = $adm_form->std_user;
        }
        $total = $adm_form->getAdmFeeTotal();

        // $adm_form = \App\AdmissionForm::findOrFail($request->form_no);
        // $std_user = $adm_form->std_user;
        // abort_if((!$std_user), '401', 'No authenticated student found!');
        abort_if((floatval($request->amount) <= 0 || floatval($request->amount) != $total), '401', 'Invalid Transaction. Please try again!!');
        if ($adm_form->student) {
            $rules = ['admitted' => "required"];
            $messages = ['admitted.required' => "Student is already admitted!"];
            $this->validate($request, $rules, $messages);
        }

        if (Payment::incompleteTransactions($std_user->id)->count() > 0) {
            flash()->warning('There are incomplete transactions, please wait for some time.');
            return redirect()->back();
        }

        $dt = \Carbon\Carbon::now();
        $payment = new Payment();
        $payment->fill([
            'trcd' => str_random(15),
            'trn_type' => 'admission_fee',
            'email' => $std_user->email,
            'mobile' => $std_user->mobile,
            'amt' => $request->amount,
            'trdate' => date('mdYHis'),
            'trntime' => $dt->toDateTimeString(),
            'through' => 'sbipay',
        ]);
        $payment->std_user_id = $std_user->id;

        // $fee_str = $student_det->getAdmFeeStr();
        // $misc_charges = $student_det->getMiscCharges();
        // $other_charges = $student_det->getOtherCharges();

        $payment->save();
        $name = $std_user->adm_form ? $std_user->adm_form->name : '';

        if ($payment->through == 'sbipay') {
            $trn_url = config('services.sbipay.trn_url');
            $mer_key = config('services.sbipay.mer_key');
            $mer_id = config('services.sbipay.mer_id');
            $op_mode = 'DOM';
            $country = 'IN';
            $currency = 'INR';
            $amount = $payment->amt;
            $others = "^Name: {$name}^Email: {$payment->email}^Mobile: {$payment->mobile}";
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
                'firstname' => ($std_user->adm_form ? $std_user->adm_form->name : ''),
                'email' => $payment->email,
                'phone' => $payment->mobile,
                'surl' => action('Payments\TransController@store'),
                'furl' => action('Payments\TransController@store'),
                'service_provider' => 'payu_paisa'
            );
            // dd($data);
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

    public function printReceipt(Request $request, $id)
    {
        //
        $adm_fees = Payment::find($id);
        $receipt = new \App\Printings\AdmFeeReceipt();
        $pdf = $receipt->makepdf($adm_fees);
        $pdf->Output("Receipt$adm_fees->id.pdf", 'I');
    }
}
