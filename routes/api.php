<?php

use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'authenticate']);

    Route::post('register', [AuthController::class, 'register']);

    Route::get('products', [ProductsController::class, 'index']);

    Route::get('categories', [CategoryController::class, 'index']);

    Route::get('categories/{id}', [CategoryController::class, 'show']);

    Route::middleware('jwt.verify')->group(function () {
        Route::post('products', [ProductsController::class, 'store']);

        Route::put('products/{id}', [ProductsController::class, 'update']);

        Route::delete('products/{id}', [ProductsController::class, 'destroy']);

        Route::post('categories', [CategoryController::class, 'store']);
    });
});
