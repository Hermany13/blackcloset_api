<?php

namespace App\Http\Middleware;

use App\Http\Responses;
use Closure;
use Illuminate\Http\Request;

class VerifyRole
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
        $role = auth()->user()->getAttributes();

        if ($role['role'] == 0) {
            return $next($request);
        }

        return Responses::Success('You are not the admin');
    }
}
