<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class RedirectNotVerifiedCustomer{
    public function handle($request, Closure $next){
        if(
            auth('customer')->user() &&
            !is_null(auth('customer')->user()->verification_code) &&
            $request->route()->getName() !='verify'
        ){
             return redirect()->to(route('verify',auth('customer')->id()));
        }

        if(auth('api-customers')->user() && auth('api-customers')->user()->status!='active'){
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message'=>__('site.your_account_has_been_deactivated')],401);
        }
        return $next($request);
    }
}
