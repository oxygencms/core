<?php

namespace Oxygencms\Core\Providers;

use Validator;
use Oxygencms\Core\Rules\ClassExists;
use Illuminate\Support\Facades\Route;
use Oxygencms\Core\Controllers\LanguageController;
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
        Route::middleware(['web', 'admin'])
            ->prefix('admin')
            ->namespace($this->namespace)
            ->group(function () {
                Route::patch('update/active/{model_name}/{model_id}', 'ModelController@updateActive');
                Route::delete('seek-and-destroy/{model_name}/{model_id}', 'ModelController@destroy');
                Route::get('/', 'DashboardController@index')->name('admin.dashboard');
            });

        // Set Locale
        Route::get('lang/{lang}', LanguageController::class . '@setLocale')->name('language');
    }

    /**
     * Bind the {model_name} to retrieve a model instance.
     *
     * @return void
     */
    protected function bindModelName(): void
    {
        Route::bind('model_name', function ($model_name) {

            // todo: fix name spacing issue
            $class = app()->getNamespace() . 'Models\\' . $model_name;

            Validator::make(['class' => $class], [
                'class' => ['required', 'string', new ClassExists()],
            ])->validate();

            return new $class;
        });
    }
}
