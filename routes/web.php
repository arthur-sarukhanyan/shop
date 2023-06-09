<?php

use App\Http\Controllers\Admin\AdminAuthController;
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
    Route::get('login', [AdminAuthController::class, 'viewLogin'])->name('admin-login');
    Route::post('login', [AdminAuthController::class, 'login']);

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [ProductController::class, 'list']);
        Route::get('products', [ProductController::class, 'list'])->name('products-list');
        Route::get('products/create', [ProductController::class, 'viewCreate'])->name('products-create');
        Route::post('products/create', [ProductController::class, 'create']);

        Route::middleware(['super-admin'])->group(function () {
            Route::get('users', [UserController::class, 'list'])->name('users-list');;
            Route::get('users-create', [UserController::class, 'create'])->name('users-create');;
        });
    });
});
