<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

Route::namespace('Api')->group(static function () {
    Route::prefix('categories')->group(function () {
        Route::get('', [CategoryController::class, 'index']);
        // Route::get('const', [OrderController::class, 'getConsts']);
        // Route::post('', [OrderController::class, 'store']);
        // Route::prefix('{order}')->group(function () {
        //     Route::get('', [OrderController::class, 'get']);
        //     Route::post('', [OrderController::class, 'update']);
        //     Route::delete('', [OrderController::class, 'delete']);
        // });
    });
});
