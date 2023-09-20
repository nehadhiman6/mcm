<?php

namespace App\Http\Controllers\Online;

use App\StudentUser;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

class OnlineRegController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admforms';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:students');
        view()->share('signedIn', auth()->guard('students')->check());
        view()->share('user', auth()->guard('students')->user());
        view()->share('dashboard', 'online.dashboard');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:' . getYearlyDbConn() . '.student_users',
            'mobile' => 'required|min:10|max:10',
            'password' => 'required|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'g_recaptcha_response' => 'required|captcha'
        ], [
            'g_recaptcha_response.required' => 'Captcha authentication is required.',
            'password.regex' => 'Passwords should be combination of (Uppercase letters: A-Z),(Lowercase letters: a-z),(Numbers: 0-9) and (Symbols) .'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return StudentUser::create([
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        //    $user = StudentUser::findOrFail(5);

        $user->sendActivationNotofication();
        flash()->success('You are registered! Activation mail has been e-mailed, Please check.');
        return response('You are registered! Activation mail has been e-mailed, Please check.');
    }

    public function resendActLink()
    {
        return view('online.activation_link');
    }

    public function postResendActLink(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:' . getYearlyDbConn() . '.student_users',
            'g-recaptcha-response' => 'required|captcha'
        ], [
            'g-recaptcha-response.required' => 'Captcha authentication is required.'
        ]);
        $user = StudentUser::whereEmail($request->email)->firstOrFail();
        if ($user->confirmed) {
            flash()->warning('You account has already been activated!');
        } else {
            $user->sendActivationNotofication();
            flash()->success('Activation mail has been e-mailed to you, Please check.');
        }
        return back();
    }

    public function verify($token)
    {
        //    dd($token);
        $std_user = StudentUser::where('confirmation_code', $token)->firstOrFail();
        if ($std_user->confirmed == 0) {
            $std_user->verified();
            flash()->success('Account is Activated Successfully!! Please login to fill the admission form.');
        } else {
            flash()->success('Account is already activated, Please login to fill the admission form.');
        }
        return redirect('stulogin');
    }

    protected function guard()
    {
        return Auth::guard('students');
    }

    public function showRegistrationForm()
    {
        return view('online.buyprospectus');
    }

    public function getCourses(Request $request)
    {
        $rules = [
            'course_id' => 'required|integer|nullable|exists:' . getYearlyDbConn() . '.courses,id',
        ];
        $messages = [
            'course_id.integer' => 'Select Atleast One Course You Want To Study'
        ];
        $this->validate($request, $rules, $messages);
        $course = \App\Course::where('id', '=', $request->course_id)->first();
        //  dd($course);
        if ($course->no_of_seats == 0 && $course->adm_open == 'N' && $course->adm_close_date == today()) {
            // dd('here');
            $rules['course'] = 'required';
            $messages += [
                'course.required' => 'Registration Closed For This Course!!'
            ];
        }
        return compact('course');
    }
}
