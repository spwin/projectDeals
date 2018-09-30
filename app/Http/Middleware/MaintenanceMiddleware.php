<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MaintenanceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(config('app.maintenance') == false) {
            return $next($request);
        }

        if(config('app.maintenance') == true){
            if(in_array($request->path(), ['coming-soon']) || $this->allowedConnection($request)){
                return $next($request);
            }
        }


        if($request->wantsJson()) {
            return response()->json(['error' => 'unauthorized'], 401);
        } else {
            return redirect()->route('maintenance');
        }
    }

    private function allowedConnection(Request $request){
        $allowed = false;
        if($this->allowedIP($request) || $this->allowedReferer($request)){
            $allowed = true;
        }
        return $allowed;
    }

    private function allowedReferer(Request $request){
        $allowed = false;
        if($referer = getDomain($request->headers->get('referer'))){
            if(in_array($referer, $this->getAllowedDomains())){
                $allowed = true;
            }
        }
        return $allowed;
    }

    private function allowedIP(Request $request){
        return in_array($request->ip(), $this->getAllowedIPs());
    }

    private function getAllowedIPs(){
        return [
            '127.0.0.1'
        ];
    }

    private function getAllowedDomains(){
        return [
            'facebook.com'
        ];
    }
}
