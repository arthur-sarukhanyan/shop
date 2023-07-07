<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FilterController;
use App\Http\Controllers\Admin\FilterGroupController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')->group(function () {
    Route::controller(AdminAuthController::class)->group(function () {
        Route::get('login', 'viewLogin')->name('admin-login');
        Route::post('login', 'login');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::controller(ProductController::class)->group(function () {
            Route::get('/', 'viewList');
            Route::get('products', 'viewList')->name('products-list');
            Route::get('products/create', 'viewCreate')->name('products-create');
            Route::post('products/create', 'create');
            Route::get('products/update/{id}', 'viewUpdate')->name('products-update');
            Route::post('products/update/{id}', 'update');
            Route::delete('products/delete/{id}', 'delete');
        });

        Route::controller(CategoryController::class)->group(function () {
            Route::get('categories', 'viewList')->name('categories-list');
            Route::get('categories/create', 'viewCreate')->name('categories-create');
            Route::post('categories/create', 'create');
            Route::get('categories/update/{id}', 'viewUpdate')->name('categories-update');
            Route::post('categories/update/{id}', 'update');
        });

        Route::controller(FilterController::class)->group(function () {
            Route::get('filters', 'viewList')->name('filters-list');
            Route::get('filters/create', 'viewCreate')->name('filters-create');
            Route::post('filters/create', 'create');
            Route::get('filters/update/{id}', 'viewUpdate')->name('filters-update');
            Route::post('filters/update/{id}', 'update');
        });

        Route::controller(FilterGroupController::class)->group(function () {
            Route::get('filter-groups', 'viewList')->name('filter-groups-list');
            Route::get('filter-groups/create', 'viewCreate')->name('filter-groups-create');
            Route::post('filter-groups/create', 'create');
            Route::get('filter-groups/update/{id}', 'viewUpdate')->name('filter-groups-update');
            Route::post('filter-groups/update/{id}', 'update');
        });

        Route::middleware(['super-admin'])->group(function () {
            Route::controller(UserController::class)->group(function () {
                Route::get('users', 'viewList')->name('users-list');
                Route::get('users-create', 'create')->name('users-create');
            });
        });
    });
});
