<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
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
            Route::get('/', 'list');
            Route::get('products', 'list')->name('products-list');
            Route::get('products/create', 'viewCreate')->name('products-create');
            Route::post('products/create', 'create');
            Route::get('products/update/{id}', 'viewUpdate')->name('products-update');
            Route::post('products/update/{id}', 'update');
        });

        Route::controller(CategoryController::class)->group(function () {
            Route::get('categories', 'list')->name('categories-list');
            Route::get('categories/create', 'viewCreate')->name('categories-create');
            Route::post('categories/create', 'create');
            Route::get('categories/update/{id}', 'viewUpdate')->name('categories-update');
            Route::post('categories/update/{id}', 'update');
        });

        Route::middleware(['super-admin'])->group(function () {
            Route::controller(UserController::class)->group(function () {
                Route::get('users', 'list')->name('users-list');;
                Route::get('users-create', 'create')->name('users-create');;
            });
        });
    });
});
