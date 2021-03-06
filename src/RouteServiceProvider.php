<?php

namespace Oxygencms\Core;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Oxygencms\Core\Rules\ClassExists;
use Illuminate\Support\Facades\Validator;
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
             ->name('admin.')
             ->namespace($this->namespace)
             ->group(function () {
                 Route::patch('update/active/{model_name}/{model_id}', 'ModelController@updateActive')->name('update_active_model');
                 Route::delete('seek-and-destroy/{model_name}/{model_id}', 'ModelController@destroy')->name('seek_and_destroy');
                 Route::get('/', 'DashboardController@index')->name('dashboard');
             });

        Route::middleware('web')->namespace($this->namespace)->group(function () {
            Route::get('lang/{lang}', 'LanguageController@setLocale')->name('language');
        });

        // Activity logs
        Route::middleware(['web', 'admin'])
             ->name('admin.')
             ->prefix('admin')
             ->group(function () {
                 Route::resource(
                     'log',
                     config('oxygen.logs_controller'),
                     ['only' => config('oxygen.logs_routes')]
                 );
             });

        // media uploads
        Route::middleware('web')->group(function () {
            $MediaController = config('oxygen.media_controller');
            Route::post('admin/media', "$MediaController@store")->name('admin.media.store');
            Route::patch('admin/media/{media}', "$MediaController@update")->name('admin.media.update');
            Route::delete('admin/media/{media}', "$MediaController@destroy")->name('admin.media.destroy');
            Route::get('admin/media/list', "$MediaController@mediaList")->name('admin.media.list');
            Route::post('admin/media/temporary', "$MediaController@createTemporary")->name('admin.media.temporary.create');
            Route::get('admin/media/temporary/{temporary}', "$MediaController@getTemporaryMedia")->name('admin.media.temporary.get');
        });
    }

    /**
     * Bind the {model_name} to retrieve a model instance.
     * todo: refactor this
     * @return void
     */
    protected function bindModelName(): void
    {
        Route::bind('model_name', function ($model_name) {

            if (in_array($model_name, ['Permission', 'Role'])) {
                $class = 'Oxygencms\\Users\\Models\\' . $model_name;
            } elseif (in_array($model_name, ['Link'])) {
                $class = 'Oxygencms\\Menus\\Models\\' . $model_name;
            } else {
                $class = 'Oxygencms\\' . Str::plural($model_name) . '\\Models\\' . $model_name;
            }

            if ( ! class_exists($class)) {
                $class = app()->getNamespace() . "Models\\$model_name";
            }

            Validator::make(['class' => $class], [
                'class' => ['required', 'string', new ClassExists()],
            ])->validate();

            return new $class;
        });
    }
}
