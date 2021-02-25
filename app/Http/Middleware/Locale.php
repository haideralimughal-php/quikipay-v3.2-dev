<?php

namespace App\Http\Middleware;

use Closure;

class Locale
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
        if (session()->has('applocale')) {
            app()->setLocale(session()->get('applocale'));
        } else {
            app()->setLocale(config('app.fallback_locale'));
            session()->put('applocale', config('app.fallback_locale'));
        }
        return $next($request);
    }
}
