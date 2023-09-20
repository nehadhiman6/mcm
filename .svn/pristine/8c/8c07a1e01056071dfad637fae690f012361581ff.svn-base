<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class YearlyDbMiddleware
{

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
    public function handle($request, Closure $next)
    {
//    if (auth()->user()) {
//      $db = config('database.connections.mysql');
//      $db['database'] = config('database.data_name') . getFY();
//      config(['database.connections.yearly_db' => $db]);
        ////      dd(app('db'));
//    }
        // dd(auth()->guard()->guest());
        // dd(session()->all());
        getYearlyDbConn(true);
        getPrvYearDbConn(true);
        return $next($request);
    }
}
