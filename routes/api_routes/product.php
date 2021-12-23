<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::namespace('Api')->group(static function () {
    Route::prefix('products')->group(function () {
        Route::get('', [ProductController::class, 'index']);
        // Route::get('const', [OrderController::class, 'getConsts']);
        // Route::post('', [OrderController::class, 'store']);
        Route::prefix('{product}')->group(function () {
            Route::get('', [ProductController::class, 'get']);
        //     Route::post('', [OrderController::class, 'update']);
        //     Route::delete('', [OrderController::class, 'delete']);
        });
    });
});
