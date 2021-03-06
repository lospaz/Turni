<?php

namespace Modules\Shift\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Route;

class ShiftServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__  . '/../Resources/views', 'Shift');
        $this->loadTranslationsFrom(__DIR__  . '/../Resources/lang', 'Shift');
        $this->registerConfig();
        $this->registerWebRoutes();
        $this->registerApiRoutes();
        $this->loadMigrationsFrom(__DIR__  . '/../Database/Migrations');
        $this->registerFactories();

        Validator::extendImplicit('this_or_that', function ($attribute, $value, $parameters, $validator) {
            return (bool) (!empty($value) ^ (array_key_exists($parameters[0], $validator->getData()) && !empty($validator->getData()[$parameters[0]])));
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    public function registerWebRoutes()
    {
        Route::middleware('web')->namespace('Modules\Shift\Http\Controllers')
            ->group(__DIR__  . '/../Routes/web.php');
    }
    public function registerApiRoutes()
    {
      Route::prefix('api')->middleware('api')->namespace('Modules\Shift\Http\Controllers')
            ->group(__DIR__  . '/../Routes/api.php');
    }
    public function registerFactories()
    {
        if (! $this->app->environment('production')) {
            $this->app->make(Factory::class)->load(__DIR__ . '/../Database/Factories');
        }
    }

     protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/shift.php' => config_path('shift.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/shift.php', 'shift'
        );
    }
}
