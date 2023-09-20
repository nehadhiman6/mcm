<?php

namespace App\Http\Controllers\Online;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class StdLoginController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'admforms';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:students', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        // Auth::guard('web')->logout();
        return view('online.login');
    }

    protected function validateLogin(Request $request)
    {
        // logger($request->all());
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|recaptcha'
        ]);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('stulogin');
    }

    protected function authenticated(Request $request, $user)
    {
        if (!$user->confirmed) {
            $this->guard()->logout();
            $request->session()->flush();
            $request->session()->regenerate();
            flash()->warning('Account activation pending. Check your mail to complete.');
            return redirect('student/activation/link');
        }
        return redirect('new-adm-form');
    }

    protected function guard()
    {
        return Auth::guard('students');
    }
}
