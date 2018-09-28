<?php

namespace Oxygencms\Core\Providers;

use Validator;
use App\Rules\ClassExists;
//use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Oxygencms\Core\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../Routes/admin.php' => base_path('routes/admin.php')
        ], 'routes');

        $this->bindModelName();

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapAdminRoutes();
    }

    /**
     * Define the "admin" web routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::middleware(['web', 'admin'])
             ->prefix('admin')
             ->namespace($this->namespace)
             ->group(function () {
                 require __DIR__ . '/../Routes/admin.php';
             });
    }

    /**
     * Bind the {model_name} to retrieve a model instance.
     *
     * @return void
     */
    protected function bindModelName(): void
    {
        Route::bind('model_name', function ($model_name) {

            $class = app()->getNamespace() . 'Models\\' . $model_name;

            Validator::make(['class' => $class], [
                'class' => ['required', 'string', new ClassExists()],
            ])->validate();

            return new $class;
        });
    }
}
