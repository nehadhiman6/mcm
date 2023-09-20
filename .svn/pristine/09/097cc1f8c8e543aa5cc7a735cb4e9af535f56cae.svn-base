<?php

namespace App\Http\Controllers\Online;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class StdResetPasswordController extends Controller {
  /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
   */

use ResetsPasswords;

  /**
   * Where to redirect users after resetting their password.
   *
   * @var string
   */
  protected $redirectTo = '/admforms';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {
    $this->middleware('guest:students');
  }

  public function showResetForm(Request $request, $token = null) {
    return view('online.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
    );
  }

  public function broker() {
    return Password::broker('students');
  }

  protected function guard() {
    return Auth::guard('students');
  }

}
