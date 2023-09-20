<?php

namespace App\Http\Controllers\Alumni;

use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use App\AlumniUser;

class AlumniRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('guest:alumnies');
        view()->share('signedIn', auth()->guard('alumnies')->check());
        view()->share('user', auth()->guard('alumnies')->user());
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function create(array $data)
    {
        return AlumniUser::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function registerAlumniUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:alumni_users',
            'password' => 'required|min:6|confirmed',
        ]);

        event(new Registered($user = $this->create($request->all())));
        $user->confirmed = 1;
        $user->reg_code = $request->input('reg_code');
        $user->save();
        // $user->sendActivationNotification();
        Auth::guard('alumnies')->login($user);
        return ['success' => true];
        // flash()->success('You are registered! Activation mail has been e-mailed, Please check.');
        // return response('You are registered! Activation mail has been e-mailed, Please check.');
    }


    public function verify($token)
    {
        //    dd($token);
        $std_alm_user = AlumniUser::where('confirmation_code', $token)->firstOrFail();
        if ($std_alm_user->confirmed == 0) {
            $std_alm_user->verified();
            flash()->success('Account is Activated Successfully!! Please login to fill the admission form.');
        } else
            flash()->success('Account is already activated, Please login to fill the admission form.');
        return redirect('alumnilogin');
    }

    public function resendActLink()
    {
        return view('alumni.activation_link');
    }

    public function postResendActLink(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:alumani_users',
            'g-recaptcha-response' => 'required|captcha'
        ], [
            'g-recaptcha-response.required' => 'Captcha authentication is required.'
        ]);
        $user = AlumniUser::whereEmail($request->email)->firstOrFail();
        if ($user->confirmed) {
            flash()->warning('You account has already been activated!');
        } else {
            $user->sendActivationNotification();
            flash()->success('Activation mail has been e-mailed to you, Please check.');
        }
        return back();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}
