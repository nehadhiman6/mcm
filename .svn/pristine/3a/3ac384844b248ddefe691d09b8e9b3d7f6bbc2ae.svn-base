<?php

namespace App\Http\Controllers\Payments;

use App\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Online\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ReceiptRequest;
use Illuminate\Support\Facades\Log;

class StdPaymentController extends Controller
{
    protected $fund_type = 'C';
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $std_payments = \App\Payment::where('std_user_id', auth('students')->user()->id)
                // ->where('ourstatus', '=', 'OK')
                ->orderBy('trntime', 'desc');
        if (auth('students')->user()->student) {
            $std_payments = $std_payments->orWhere('std_id', auth('students')->user()->student->id);
        }
        $std_payments = $std_payments->get();
        return view('online.stdpayments', compact('std_payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $std_user = auth('students')->user();
        // dd($std_user->receivePayment());

        $fund_type = $this->fund_type;
        if (!request()->ajax()) {
            return View('payments.pay_dues', compact('fund_type'));
        }
        $std_user = auth('students')->user();
        $student = \App\Student::where('std_user_id', '=', $std_user->id)
            ->with('course')->first();

        $pend_bal = $student->getPendingFeeDetails();
        if ($pend_bal->count() == 0) {
            return response()
              ->json(['no_balance' => ['No dues!!']], 422, ['app-status' => 'error']);
        }

        return compact('student', 'pend_bal') + ['fund_type' => $this->fund_type];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $std_user = auth('students')->user();
        $student = $std_user->student;
        if (!$student) {
            $rules = ['admitted' => "required"];
            $messages = ['admitted.required' => "No authenticated student found!"];
            $this->validate($request, $rules, $messages);
        }
        
        $dt = \Carbon\Carbon::now();
        $payment = new \App\Payment();
        $payment->fill([
                'trcd' => str_random(15),
                'trn_type' => 'college_receipt',
                'email' => $std_user->email,
                'mobile' => $std_user->mobile,
                'amt' => $request->amount,
                'trdate' => date('mdYHis'),
                'trntime' => $dt->toDateTimeString(),
                'through' => 'payu',
            ]);
        $payment->std_user_id = $std_user->id;
        $payment->save();
        
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

    public function printReceipt(Request $request, $id)
    {
        //
        $feercpt = \App\FeeRcpt::find($id);
        //    dd($feercpt->billRcptDets);
        if ($feercpt->std_id != auth('students')->user()->student->id) {
            abort(404);
        }
        $rcpt = new \App\Printings\RecPrint();
        $pdf = $rcpt->makepdf($feercpt);
        $pdf->Output("Rec$feercpt->id.pdf", 'I');
    }
}
