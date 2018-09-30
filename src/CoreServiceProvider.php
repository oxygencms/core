<?php

namespace Oxygencms\Core;

use Illuminate\Routing\Router;
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
        $router->pushMiddlewareToGroup('web', IntendedUrl::class);
        $router->pushMiddlewareToGroup('web', SetLocale::class);
        $router->aliasMiddleware('admin', BackOfficeAccess::class);

        $this->loadViewsFrom(__DIR__.'/Views', 'oxygencms');

        $this->publishes([
            __DIR__.'/Views' => resource_path('views/vendor/oxygencms'),
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

        $this->mergeConfigFrom(
            __DIR__.'/Config/oxygen.php', 'oxygen'
        );
    }
}
