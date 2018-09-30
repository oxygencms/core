<?php

namespace Oxygencms\Core\Middleware;

use Closure;

class SetLocale
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
        if (session('app_locale')) {
            app()->setLocale(session('app_locale'));
        } else {
            session()->put('app_locale', config('app.locale'));
        }

        return $next($request);
    }
}
