<?php

namespace App\Http\Middleware;

use Closure;

class HttpsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // return $next($request);
        if(env('APP_ENV') === "production") {
            if (!$request->secure()) {
                return redirect()->secure($request->path());
            }
        }
        return $next($request);

    }
}
