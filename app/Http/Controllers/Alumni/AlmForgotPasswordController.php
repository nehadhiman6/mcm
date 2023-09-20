<?php

namespace App\Http\Controllers\Alumni;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
// use App\Http\Controllers\Alumni\Controller;

class AlmForgotPasswordController extends Controller
{
    
use SendsPasswordResetEmails;

/**
 * Create a new controller instance.
 *
 * @return void
 */
public function __construct() {
  $this->middleware('guest');
}

public function showLinkRequestForm() {
  return view('alumni.passwords.email');
}

public function broker() {
  return Password::broker('alumnies');
}

protected function guard() {
  return Auth::guard('alumnies');
}

public function sendResetLinkEmail(Request $request) {
    // dd($request->all());
  $this->validate($request, [
      'email' => 'required|email|exists:alumni_users',
  ]);


  $response = $this->broker()->sendResetLink(
      $request->only('email')
  );

  return $response == Password::RESET_LINK_SENT ? $this->sendResetLinkResponse($response) : $this->sendResetLinkFailedResponse($request, $response);
}
}
