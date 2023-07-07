<?php

namespace App\Providers;

use App\Repositories\CategoryRepository;
use App\Repositories\FilterGroupRepository;
use App\Repositories\FilterRepository;
use App\Repositories\ImageRepository;
use App\Repositories\Interfaces\CategoryInterface;
use App\Repositories\Interfaces\FilterGroupInterface;
use App\Repositories\Interfaces\FilterInterface;
use App\Repositories\Interfaces\ImageInterface;
use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        UserInterface::class => UserRepository::class,
        ProductInterface::class => ProductRepository::class,
        CategoryInterface::class => CategoryRepository::class,
        ImageInterface::class => ImageRepository::class,
        FilterInterface::class => FilterRepository::class,
        FilterGroupInterface::class => FilterGroupRepository::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
