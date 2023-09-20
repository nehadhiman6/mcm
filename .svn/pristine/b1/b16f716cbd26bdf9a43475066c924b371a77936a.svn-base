<?php

namespace App\Http\Controllers\Alumni;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AlmResetPasswordController extends Controller
{
    use ResetsPasswords;
  /**
   * Where to redirect users after resetting their password.
   *
   * @var string
   */
  protected $redirectTo = '/alumnilogin';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {
    $this->middleware('guest:alumnies');
  }

  public function showResetForm(Request $request, $token = null) {
    return view('alumni.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
    );
  }

  public function broker() {
    return Password::broker('alumnies');
  }

  protected function guard() {
    return Auth::guard('alumnies');
  }
}
