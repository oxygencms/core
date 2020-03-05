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
        Gate::define('access-back-office', function ($user) {

            if ($user->superuser || $user->can('manage_back_office') || $user->can('access_back_office')) {
                return true;
            }

            return false;
        });
    }
}
