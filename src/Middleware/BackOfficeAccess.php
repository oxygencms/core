<?php

namespace Oxygencms\Core\Middleware;

use Closure;

class BackOfficeAccess
{
    /**
     * Restricts the back office access.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return auth()->check() && auth()->user()->can('access-back-office')
            ? $next($request)
            : redirect('/');
    }
}
