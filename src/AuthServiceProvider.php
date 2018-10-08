<?php

namespace Oxygencms\Core;

use Illuminate\Support\Facades\Gate;
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
        Gate::define('access-backoffice', function ($user) {

            if ($user->superuser) {
                return true;
            }

            if ($user->can('manage_back_office') || $user->hasRole('observer')) {
                return true;
            }

            return false;
        });
    }
}
