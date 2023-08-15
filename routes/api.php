<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FilterGroupController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('login', [CustomerAuthController::class, 'login']);
    Route::post('register', [CustomerAuthController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [CustomerAuthController::class, 'logout']);

        Route::controller(CustomerController::class)->group(function () {
            Route::get('profile', 'profile');
        });
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(BasketController::class)->group(function () {
        Route::get('basket', 'one');
        Route::put('basket', 'update');
    });
});

Route::controller(BasketController::class)->group(function () {
    Route::post('basket', 'submit');
});

Route::controller(ProductController::class)->group(function () {
    Route::post('products', 'list');
    Route::get('products/{id}', 'one');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('categories', 'list');
});

Route::controller(FilterGroupController::class)->group(function () {
    Route::get('filter-groups', 'list');
});

Route::controller(CountryController::class)->group(function () {
    Route::get('countries', 'list');
});

Route::controller(CustomerController::class)->group(function () {
    Route::post('profile', 'update');
});
