<?php

use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ColorsController;
use App\Http\Controllers\api\ProductHasCatController;
use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\AuthController;
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
    Route::prefix('user')->group(function () {
        Route::post('login', [AuthController::class, 'authenticate']);

        Route::post('register', [AuthController::class, 'register']);
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductsController::class, 'index']);

        Route::get('/{id}', [ProductsController::class, 'show']);

        Route::middleware('jwt.verify')->group(function () {
            Route::post('/', [ProductsController::class, 'store']);

            Route::put('/{id}', [ProductsController::class, 'update']);

            Route::delete('/{id}', [ProductsController::class, 'destroy']);

            Route::prefix('relationships')->group(function () {
                Route::post('/category/{id}', [ProductHasCatController::class, 'store']);

                Route::delete('/category/{id}', [ProductHasCatController::class, 'destroy']);
            });
        });
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);

        Route::get('/{id}', [CategoryController::class, 'show']);

        Route::middleware('jwt.verify')->group(function () {
            Route::post('/', [CategoryController::class, 'store']);

            Route::put('/{id}', [CategoryController::class, 'update']);

            Route::delete('/{id}', [CategoryController::class, 'destroy']);
        });
    });

    Route::prefix('colors')->group(function () {
        Route::get('/', [ColorsController::class, 'index']);

        Route::get('/{id}', [ColorsController::class, 'show']);

        Route::middleware('jwt.verify')->group(function () {
            Route::post('/', [ColorsController::class, 'store']);

            Route::put('/{id}', [ColorsController::class, 'update']);
        });
    });
});
