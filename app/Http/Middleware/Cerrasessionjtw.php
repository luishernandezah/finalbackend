<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class Cerrasessionjtw
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
        //dd($request->token);
        $user = JWTAuth::parseToken()->authenticate();
        JWTAuth::invalidate();
      
        return response()->json("cerrado senssion");;
        return $next($request);

    }
}
