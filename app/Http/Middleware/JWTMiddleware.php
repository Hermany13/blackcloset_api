<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JWTMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->jwtUser = JWTAuth::parseToken()->authenticate();

        return $next($request);
    }
}
