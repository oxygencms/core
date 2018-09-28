<?php

namespace Oxygencms\Core;

use Illuminate\Support\ServiceProvider;
use Oxygencms\Core\Middleware\BackOfficeAccess;
use Oxygencms\Core\Middleware\IntendedUrl;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', IntendedUrl::class);
        $router->middleware('admin', BackOfficeAccess::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('Oxygencms\Core\Providers\RouteServiceProvider');
        $this->app->register('Oxygencms\Core\Providers\AuthServiceProvider');
    }
}
