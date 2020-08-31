<?php

namespace Hotel\app\Providers;

use Hotel\app\Http\Middleware\Cors;
use Hotel\app\Http\Middleware\Json;
use Illuminate\Support\ServiceProvider;

class HotelServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    public function boot()
    {
        //INSERT PACKAGE ROUTES
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->publishes([__DIR__ . '/../../database/seeds' => database_path('seeds')], 'Seeds');

        $this->app->router->aliasMiddleware('Cors', Cors::class);
        $this->app->router->aliasMiddleware('Json', Json::class);

    }
}


