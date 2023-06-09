<?php

namespace App\Providers;

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
