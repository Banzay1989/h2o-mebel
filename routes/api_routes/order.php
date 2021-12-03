<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::namespace('Api')->group(static function () {
    Route::prefix('orders')->group(function () {
        Route::get('', [OrderController::class, 'index']);
        Route::get('const', [OrderController::class, 'getConsts']);
        Route::post('', [OrderController::class, 'store']);
        Route::prefix('{order}')->group(function () {
            Route::get('', [OrderController::class, 'get']);
            Route::put('', [OrderController::class, 'update']);
            Route::delete('', [OrderController::class, 'delete']);
        });
    });
});
