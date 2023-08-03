<?php

namespace App\Providers;

use App\Repositories\BasketItemRepository;
use App\Repositories\BasketRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CountryRepository;
use App\Repositories\CustomerDetailRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\FilterGroupRepository;
use App\Repositories\FilterRepository;
use App\Repositories\ImageRepository;
use App\Repositories\Interfaces\BasketInterface;
use App\Repositories\Interfaces\BasketItemInterface;
use App\Repositories\Interfaces\CategoryInterface;
use App\Repositories\Interfaces\CountryInterface;
use App\Repositories\Interfaces\CustomerDetailInterface;
use App\Repositories\Interfaces\CustomerInterface;
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
        BasketInterface::class => BasketRepository::class,
        BasketItemInterface::class => BasketItemRepository::class,
        CustomerDetailInterface::class => CustomerDetailRepository::class,
        CountryInterface::class => CountryRepository::class,
        CustomerInterface::class => CustomerRepository::class,
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
