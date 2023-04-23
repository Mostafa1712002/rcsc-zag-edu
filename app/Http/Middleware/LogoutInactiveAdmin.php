<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LogoutInactiveAdmin{
    public function handle($request, Closure $next) {
        if ( auth('admin')->check() && auth('admin')->user()->status == 'inactive') {
            $request->session()->flush();
            auth('admin')->logout();
            return redirect()->to(route('login'))->with('error_message',__('site.your_account_has_been_deactivated'));
        }

        return $next($request);
    }
}
