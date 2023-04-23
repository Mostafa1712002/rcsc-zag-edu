<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectNotLoggedInCustomer{
    public function handle(Request $request, Closure $next){
        if(!auth('customer')->check()){
            return redirect()->to(route('customer.login'));
        }
        return $next($request);
    }
}
