<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Providers\RouteServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS on Vercel (serverless environment uses HTTPS always)
        if ($this->app->environment('production') || env('FORCE_HTTPS', false)) {
            URL::forceScheme('https');
        }
    }
}
