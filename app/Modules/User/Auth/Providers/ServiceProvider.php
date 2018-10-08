<?php

namespace App\Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        //helpers
        $this->app->bind('App\Modules\User\Auth\Interfaces\RequestParserInterface', 'App\Modules\User\Auth\Helpers\RequestParser');
        $this->app->bind('App\Modules\User\Auth\Interfaces\ResponseParserInterface', 'App\Modules\User\Auth\Helpers\ResponseParser');
        $this->app->bind('App\Modules\User\Auth\Interfaces\MobileAuthHelperInterface', 'App\Modules\User\Auth\Helpers\MobileAuthHelper');
    
        //services
        $this->app->bind('App\Modules\User\Auth\Interfaces\MobileAuthServiceInterface', 'App\Modules\User\Auth\Services\MobileAuthService');
    
        //repositories
        $this->app->bind('App\Modules\User\Auth\Interfaces\MobileAuthRepositoryInterface', 'App\Modules\User\Auth\Repositories\MobileAuthRepository');
    
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
