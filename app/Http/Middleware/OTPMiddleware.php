<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OTPMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param null $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        if($user = Auth::guard($role)->user()){
            if($token = session()->get('2fa_auth_'.$user->google2fa_ts)){
                if($token = salt2fa($user)){
                    return $next($request);
                }
            }
            return redirect()->route($role.'.login.2fa');
        }

        if($request->wantsJson()) {
            return response()->json(['error' => 'unauthorized'], 401);
        } else {
            return redirect()->route($role.'.login.form');
        }
    }
}
