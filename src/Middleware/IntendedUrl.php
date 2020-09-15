<?php

namespace Oxygencms\Core\Middleware;

use Closure;

class IntendedUrl
{
    /**
     * Keep the path for redirect after login.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->guest() && !request()->is('login')) {

            if (! session()->has('intended_url')) {
                session()->put('intended_url', $request->path());
            }

            if ($request->is('*admin*')) {
                return redirect('login');
            }
        }

        return $next($request);
    }
}
