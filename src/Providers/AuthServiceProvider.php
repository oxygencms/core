<?php

namespace Oxygencms\Core\Providers;

use Oxygencms\Core\Gates\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        (new Gate)->registerAuthGate();
    }
}
