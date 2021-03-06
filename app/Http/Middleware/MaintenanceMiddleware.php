<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        if($this->allowedIP($request) || $this->allowedReferer($request) || $this->allowedUserAgent($request)){
            $allowed = true;
        }
        return $allowed;
    }

    private function allowedUserAgent(Request $request){
        $allowed = false;
        $agent = $request->headers->get('user-agent');
        if(in_array($agent, $this->getAllowedUserAgents())){
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
            '127.0.0.1',
            '79.66.162.252'
        ];
    }

    private function getAllowedDomains(){
        return [
            'facebook.com',
            'twitter.com'
        ];
    }

    private function getAllowedUserAgents(){
        return [
            'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)',
            'Twitterbot/1.0'
        ];
    }
}
