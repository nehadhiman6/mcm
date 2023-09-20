<?php

namespace App\Http\Controllers\Alumni;

use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
use App\AlumniUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class AlumniLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */

    use AuthenticatesUsers;
    protected $redirectTo = 'alumni-student';

    public function __construct()
    {
        $this->middleware('guest:alumnies', ['except' => 'logout']);
    }

    public function index()
    {
        return view('alumni.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegisterAlumniUser()
    {
        // if ($reg_code = request('reg_code')) {
        //     dd($reg_code);
        // };
        return view('alumni.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


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

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('alumnilogin');
    }

    protected function authenticated(Request $request, $user)
    {
        if (!$user->confirmed) {
            $this->guard()->logout();
            $request->session()->flush();
            $request->session()->regenerate();
            flash()->warning('Account activation pending. Check your mail to complete.');
            return redirect('alumni/activation/link');
        }
        return redirect('alumni-student');
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

    protected function guard()
    {
        return Auth::guard('alumnies');
    }
}
