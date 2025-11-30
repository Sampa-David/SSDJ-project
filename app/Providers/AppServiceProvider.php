<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Force HTTPS in production (Railway uses HTTPS reverse proxy)
        if (env('APP_ENV') === 'production' || env('FORCE_HTTPS') === 'true') {
            URL::forceScheme('https');
        }
        
        // Trust Railway's reverse proxy headers
        if (env('TRUSTED_PROXIES') === '*') {
            \Illuminate\Http\Request::setTrustedProxies(
                ['*'],
                \Illuminate\Http\Request::HEADER_X_FORWARDED_FOR |
                \Illuminate\Http\Request::HEADER_X_FORWARDED_HOST |
                \Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO |
                \Illuminate\Http\Request::HEADER_X_FORWARDED_PORT
            );
        }
    }
}
