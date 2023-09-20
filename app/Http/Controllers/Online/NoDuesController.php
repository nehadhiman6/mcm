<?php

namespace App\Http\Controllers\Online;

use App\Jobs\SendSms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Student;
use App\StudentUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NoDuesController extends Controller
{
    public function __construct()
    {
        getYearlyDbConn(true);
        $this->middleware('auth:students', ['except' => 'verify']);
        $this->middleware(function ($request, $next) {
            view()->share('signedIn', auth('students')->check());
            view()->share('loggedUser', auth('students')->user());
            return $next($request);
        });
        view()->share('guard', 'students');
        view()->share('dashboard', 'online.dashboard');
    }

    public function index(Request $request)
    {
        $login = auth('students');
        $student = Student::where('std_user_id', $login->user()->id)->first();
        // dd($student);
        $student->load('course');
        $studentuser = StudentUser::where('id', $login->user()->id)->first();
        // dd($studentuser);
        return view('online/no_dues', compact('student', 'studentuser'));
    }
    
    public function store(Request $request)
    {
    }

    public function update(Request $request, $id)
    {
        $session_otp = session()->get('otp');
        $session_otp_date = session()->get('otp_time');
        $session_mobile = session()->get('session_mobile');
        $valid_time = Carbon::parse($session_otp_date)->addMinutes(10);
        $now = Carbon::now();

        $rules = [
            'father_mobile' => 'required|digits:10|numeric',
            'mother_mobile' => 'required|digits:10|numeric',
            'email2' => 'required|email',
        ];

        $std_user = $request->user();
        if ($std_user && $std_user->mobile_verified == 'N') {
            $rules += [
                'stu_mobile' => "required|digits:10|numeric|in:{$session_mobile}",
                'otp' => "required|in:{$session_otp}",
            ];
            if ($now >= $session_otp_date && $now > $valid_time) {
                $rules += [
                    'validate_time' => 'required'
                ];
            }
        }

        $this->validate(
            $request,
            $rules,
            [
                'stu_mobile' => 'Student Mobile No. is required',
                'stu_mobile.digits' => 'Student Mobile must be 10 digits.',
                'father_mobile' => 'Father Mobile No. is required',
                'father_mobile.digits' => 'Father Mobile must be 10 digits.',
                'validate_time.required' => 'OTP Expired please resend OTP request.',
                'mother_mobile' => 'Mother Mobile No. is required',
                'mother_mobile.digits' => 'Mother Mobile must be 10 digits.',
                // 'email2' => 'required|email|exists:student_users,id',
            ]
        );
        $student = Student::findOrFail($id);
        $student->father_mobile = $request->father_mobile;
        $student->mother_mobile = $request->mother_mobile;
        // dd($std_user->email2);
        $std_user->email2 = $request->email2;
        if ($std_user->mobile_verified == 'N') {
            $std_user->mobile_verified = 'Y';
            $student->mobile = $request->stu_mobile;
            $std_user->mobile = $request->stu_mobile;
        }
        DB::beginTransaction();
        $student->save();
        $std_user->save();
        DB::commit();
        $std_user->sendEmail2ActivationNotofication();
        return redirect('no-dues')
            ->with('success', 'An Email verification link has been sent to your mentioned Email Id. Please Activate to verify !!', array('timeout' => 3000));
    }

    public function sendOtp(Request $request)
    {
        $random =  rand(1000, 9999);
        session()->put('otp', $random);
        session()->put('session_mobile', $request->mobile);
        session()->put('otp_time', Carbon::now()->toDateTimeString());

        dispatch(new SendSms("Your OTP for mobile verification is {$random}", $request->mobile));

        // return response()->json([
        //     'session_otp' => session()->get('otp'),
        //     'session_time' => session()->get('otp_time')
        // ]);
        return reply('OK');
    }

    public function verify($token)
    {
        //    dd($token);
        $std_user = StudentUser::where('email2_code', $token)->first();
        if (!$std_user) {
            flash('Invalid Token! Try to update email again on no dues screen!');
            return redirect('stulogin');
        }

        if ($std_user->email2_confirmed == 'N') {
            $std_user->confirm_email2();
            flash()->success('Email is confirmed Successfully!!');
        } else {
            flash()->success('Email is already confirmed.');
        }
        return redirect('stulogin');
    }
}
