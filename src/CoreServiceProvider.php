<?php

namespace Oxygencms\Core;

use Illuminate\Routing\Router;
use Oxygencms\Core\Gates\Gate;
use Illuminate\Support\ServiceProvider;
use Oxygencms\Core\Middleware\SetLocale;
use Oxygencms\Core\Middleware\IntendedUrl;
use Oxygencms\Core\Middleware\BackOfficeAccess;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @param Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        (new Gate)->registerAuthGate();

        $this->loadViewsFrom(__DIR__.'/../views', 'oxygencms');

        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/oxygencms'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../assets' => resource_path(),
        ], 'assets');

        $this->publishes([
            __DIR__.'/../database/seeds' => database_path('seeds'),
        ], 'seeds');

        $this->publishes([
            __DIR__.'/../config/oxygen.php' => config_path('oxygen.php')
        ], 'config');

        $router->pushMiddlewareToGroup('web', IntendedUrl::class);
        $router->pushMiddlewareToGroup('web', SetLocale::class);

        $router->aliasMiddleware('admin', BackOfficeAccess::class);

        \View::share('error_message', "<small class='text-danger'>:message</small>");
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->mergeConfigFrom(__DIR__.'/../config/oxygen.php', 'oxygen');
    }
}
