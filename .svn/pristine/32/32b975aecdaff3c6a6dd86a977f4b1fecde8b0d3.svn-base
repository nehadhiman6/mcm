<?php

namespace App\Http\Controllers\Online;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use \Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public function __construct(Request $request)
    {
        getYearlyDbConn(true);
        $this->middleware('auth:students');
        $this->middleware(function ($request, $next) {
            view()->share('signedIn', auth('students')->check());
            view()->share('loggedUser', auth('students')->user());
            return $next($request);
        });
        view()->share('guard', 'students');
        view()->share('dashboard', 'online.dashboard');
    }
}
