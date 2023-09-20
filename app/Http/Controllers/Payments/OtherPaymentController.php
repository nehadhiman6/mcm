<?php

namespace App\Http\Controllers\Payments;

use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Outsider;

class OtherPaymentController extends BaseController
{
    use ValidatesRequests;

    protected $fund_type = 'H';

    public function __construct(Request $request)
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('errors.503');
        $fund_type = $this->fund_type;
        if (!request()->ajax()) {
            return View('payments.pay_dues_direct', compact('fund_type') + ['outsider' => 'Y']);
        }

        $this->validate($request, [
            'adm_no' => 'required|exists:' . getYearlyDbConn() . '.outsiders,adm_no'
        ]);
        $student = Outsider::where('adm_no', '=', $request->adm_no)
            ->with('course')->firstOrFail();

        $pend_bal = $student->getPendingFeeDetails($this->fund_type);
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
        return view('errors.503');
        // return $request->all();
        // $std_user = auth('students')->user();
        $student = Outsider::whereAdmNo($request->adm_no)->first();
        // dd($student);
        if (!$student) {
            $rules = ['admitted' => "required"];
            $messages = ['admitted.required' => "No student found with the given admission number!"];
            $this->validate($request, $rules, $messages);
        }
        
        $dt = \Carbon\Carbon::now();
        $payment = new \App\Payment();
        $payment->fill([
                'trcd' => str_random(15),
                'trn_type' => 'direct_hostel_receipt',
                'outsider_id' => $student->id,
                'email' => trim($student->email),
                'mobile' => trim($student->mobile),
                'amt' => $request->amount,
                'trdate' => date('mdYHis'),
                'trntime' => $dt->toDateTimeString(),
                'through' => 'payu',
            ]);
        $payment->std_user_id = 0;
        $payment->last_fee_bill_id = $request->last_fbid;
        $payment->fund = $this->fund_type;
        $payment->save();
        
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
