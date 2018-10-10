<?php

namespace App\Modules\User\Profile\Providers;

use Illuminate\Support\ServiceProvider;

class UserProfileServiceProvider extends ServiceProvider
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
        // helpers
        $this->app->bind('App\Modules\User\Profile\Contracts\ProfileResponseParserInterface', 'App\Modules\User\Profile\Helpers\ProfileResponseParser');
        $this->app->bind('App\Modules\User\Profile\Contracts\ProfileRequestParserInterface', 'App\Modules\User\Profile\Helpers\ProfileRequestParser');
        // services
        $this->app->bind('App\Modules\User\Profile\Contracts\ProfileServiceInterface', 'App\Modules\User\Profile\Services\ProfileService');
    }
}