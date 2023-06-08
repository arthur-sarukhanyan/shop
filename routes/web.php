<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProductController;
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
        Route::get('/', [ProductController::class, 'viewList']);
        Route::get('products', [ProductController::class, 'viewList']);
        Route::get('products/create', [ProductController::class, 'viewCreate'])->name('products-create');
        Route::post('products/create', [ProductController::class, 'create']);
    });
});
