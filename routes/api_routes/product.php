<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::namespace('Api')->group(static function () {
    Route::prefix('products')->group(function () {
        Route::get('', [ProductController::class, 'index']);
        // Route::get('const', [OrderController::class, 'getConsts']);
        Route::post('', [ProductController::class, 'store'])->middleware('is_admin');
        Route::prefix('{product}')->group(function () {
            Route::get('', [ProductController::class, 'get']);
            Route::post('', [ProductController::class, 'update'])->middleware('is_admin');
            Route::delete('', [ProductController::class, 'delete'])->middleware('is_admin');
        });
    });
});
