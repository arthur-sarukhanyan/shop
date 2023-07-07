<?php

namespace App\Providers;

use App\Services\CategoryService;
use App\Services\FilterGroupService;
use App\Services\FilterService;
use App\Services\ImageService;
use App\Services\ProductCategoryService;
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

        $this->app->bind('CategoryService', function (Application $app) {
            return app()->make(CategoryService::class);
        });

        $this->app->bind('ImageService', function (Application $app) {
            return app()->make(ImageService::class);
        });

        $this->app->bind('FilterService', function (Application $app) {
            return app()->make(FilterService::class);
        });

        $this->app->bind('FilterGroupService', function (Application $app) {
            return app()->make(FilterGroupService::class);
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
