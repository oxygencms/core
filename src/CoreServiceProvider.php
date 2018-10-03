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
        
        $router->pushMiddlewareToGroup('web', IntendedUrl::class);
        $router->pushMiddlewareToGroup('web', SetLocale::class);
        $router->aliasMiddleware('admin', BackOfficeAccess::class);

        $this->loadViewsFrom(__DIR__.'/../views', 'oxygencms');

        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/oxygencms'),
        ], 'views');

        $this->publishes([
            __DIR__.'/Assets' => resource_path('vendor/oxygencms'),
        ], 'vendor-assets');

        $this->publishes([
            __DIR__.'/Assets' => resource_path(),
        ], 'assets');

        $this->publishes([
            __DIR__.'/Config/oxygen.php' => config_path('oxygen.php')
        ], 'config');

        \View::share('error_message', "<small class='text-danger'>:message</small>");
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('Oxygencms\Core\Providers\RouteServiceProvider');

        $this->mergeConfigFrom(
            __DIR__.'/Config/oxygen.php', 'oxygen'
        );
    }
}
