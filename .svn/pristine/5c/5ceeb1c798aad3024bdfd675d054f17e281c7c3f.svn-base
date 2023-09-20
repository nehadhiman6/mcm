<?php

namespace App\Http\Middleware;

use Closure;

class CacheControl
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
        $response = $next($request);

        $headers = [
            'pragma' => 'no-cache',
            'Cache-Control' => 'no-store,no-cache, must-revalidate'
        ];

        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }

        // $response->header('pragma', 'no-cache')
        //     ->header('Cache-Control', 'no-store,no-cache, must-revalidate');
        // Or whatever you want it to be:
        // $response->header('Cache-Control', 'max-age=100');

        return $response;
    }
}
