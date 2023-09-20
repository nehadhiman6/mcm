<?php

namespace App\Http\Controllers\Alumni;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendAlumniRegSms;
// use Illuminate\Support\Facades\Gate;
use Gate;

class SendRegSmsAlumniController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('send-regsms-alumni')) {
            return deny();
        }
        // dispatch(new SendAlumniRegSms(''));
        dispatch((new SendAlumniRegSms(''))->onQueue('longjobs'));
        return;

        // if (Gate::denies('alumni-sms-mail')) {
        //     return deny();
        // }

        // if (!request()->ajax()) {
        //     return view('alumni.sms.reg_sms');
        // }
        // $this->validate($request, [
        //     'course_id' => 'nullable|required_with:type|integer',
        //     'type' => 'nullable|in:UG,PG,All'
        // ]);
        // $students = \App\AlumniStudent::whereId(2)->get();
        // return $students;
    }
}
