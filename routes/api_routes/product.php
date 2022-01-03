<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::namespace('Api')->group(static function () {
    Route::prefix('products')->group(function () {
        Route::get('', [ProductController::class, 'index']);
        // Route::get('const', [OrderController::class, 'getConsts']);
        Route::post('', [ProductController::class, 'store']);
        Route::prefix('{product}')->group(function () {
            Route::get('', [ProductController::class, 'get']);
            Route::post('', [ProductController::class, 'update']);
            Route::delete('', [ProductController::class, 'delete']);
        });
    });
});
