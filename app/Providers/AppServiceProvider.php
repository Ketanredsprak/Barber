<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use SocialiteProviders\Apple\Provider;
use Illuminate\Support\ServiceProvider;


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
        //
        Paginator::useBootstrap();
        Schema::defaultStringLength(125);
          // Register the Apple provider
        $this->app->make('Laravel\Socialite\Contracts\Factory')->extend('apple', function ($app) {
            $config = $app['config']['services.apple'];
            return new Provider(
                $app['request'], $config['client_id'], $config['client_secret'], $config['redirect']
            );
        });
    }
}
