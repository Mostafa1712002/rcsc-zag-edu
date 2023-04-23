<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutInactiveCustomer{
    public function handle($request, Closure $next){

        return $next($request);
    }
}
