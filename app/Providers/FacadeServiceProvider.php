<?php

namespace App\Providers;

use App\Services\ProductService;
use App\Services\UserService;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('UserService', function (Application $app) {
            return app()->make(UserService::class);
        });

        $this->app->bind('ProductService', function (Application $app) {
            return app()->make(ProductService::class);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
