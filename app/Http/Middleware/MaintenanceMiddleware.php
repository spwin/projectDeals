<?php

namespace App\Http\Middleware;

use Closure;

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
        if(config('app.maintenance') == false || (config('app.maintenance') == true && in_array($request->path(), ['coming-soon']))) {
            return $next($request);
        }


        if($request->wantsJson()) {
            return response()->json(['error' => 'unauthorized'], 401);
        } else {
            return redirect()->route('maintenance');
        }
    }
}
