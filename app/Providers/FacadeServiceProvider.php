<?php

namespace App\Providers;

use App\Services\BasketItemService;
use App\Services\BasketService;
use App\Services\CategoryService;
use App\Services\CountryService;
use App\Services\CustomerDetailService;
use App\Services\CustomerService;
use App\Services\FilterGroupService;
use App\Services\FilterService;
use App\Services\ImageService;
use App\Services\OrderDetailService;
use App\Services\OrderService;
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

        $this->app->bind('BasketService', function (Application $app) {
            return app()->make(BasketService::class);
        });

        $this->app->bind('BasketItemService', function (Application $app) {
            return app()->make(BasketItemService::class);
        });

        $this->app->bind('CustomerDetailService', function (Application $app) {
            return app()->make(CustomerDetailService::class);
        });

        $this->app->bind('CountryService', function (Application $app) {
            return app()->make(CountryService::class);
        });

        $this->app->bind('CustomerService', function (Application $app) {
            return app()->make(CustomerService::class);
        });

        $this->app->bind('OrderService', function (Application $app) {
            return app()->make(OrderService::class);
        });

        $this->app->bind('OrderDetailService', function (Application $app) {
            return app()->make(OrderDetailService::class);
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
