<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Contracts\RequestValidatorInterface', 'App\Helpers\RequestValidator');
        $this->app->bind('App\Contracts\ResponseFormatterInterface', 'App\Helpers\ResponseFormatter');
    }
}
