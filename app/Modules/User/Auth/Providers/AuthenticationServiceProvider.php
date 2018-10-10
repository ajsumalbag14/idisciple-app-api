<?php

namespace App\Modules\User\Auth\Providers;

use Illuminate\Support\ServiceProvider;

class AuthenticationServiceProvider extends ServiceProvider
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
        //helpers
        $this->app->bind('App\Modules\User\Auth\Contracts\AuthResponseFormatterInterface', 'App\Modules\User\Auth\Helpers\AuthResponseFormatter');
    
        //services
        $this->app->bind('App\Modules\User\Auth\Contracts\AuthCredentialsInterface', 'App\Modules\User\Auth\Services\AuthCredentials');
    
    }
}
