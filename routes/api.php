<?php

use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
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
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout']);
    });
//    Route::post('logout', [CustomerAuthController::class, 'logout']);
//    Route::post('refresh', [CustomerAuthController::class, 'refresh']);
//    Route::post('me', [CustomerAuthController::class, 'me']);
});

Route::prefix('admin')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout']);
    });

    Route::post('login', [AdminAuthController::class, 'login']);
});

//Products
Route::post('products', [ProductController::class, 'create']);
Route::get('products', [ProductController::class, 'list']);
