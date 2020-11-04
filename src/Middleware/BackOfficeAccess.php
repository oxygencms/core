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
        if (! auth()->check() || ! auth()->user()->can('access-back-office')) {
            return redirect('/');
        }

        if (config('auth.admin.trusted_ips')) {
            if (! in_array($request->ip(), explode('|', config('oxygen.admin.trusted_ips')))) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
