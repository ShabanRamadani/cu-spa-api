<?php

namespace Spa\Providers;

use Illuminate\Support\ServiceProvider;
use Spa\Listeners\Jwt\TokenAbsent;
use Spa\Listeners\Jwt\TokenExpired;
use Spa\Listeners\Jwt\TokenInvalid;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Schema::defaultStringLength(191);
        $this->app->make('events')->listen('tymon.jwt.absent', TokenAbsent::class);
        $this->app->make('events')->listen('tymon.jwt.expired', TokenExpired::class);
        $this->app->make('events')->listen('tymon.jwt.invalid', TokenInvalid::class);
        $this->app->make('events')->listen('tymon.jwt.user_not_found', UserNotFound::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
