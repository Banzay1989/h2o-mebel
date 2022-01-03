<?php

use App\Http\Controllers\Api\BrandController;
use Illuminate\Support\Facades\Route;

Route::namespace('Api')->group(static function () {
    Route::prefix('brands')->group(function () {
        Route::get('', [BrandController::class, 'index']);
        // Route::post('', [CategoryController::class, 'store']);
        // Route::prefix('{category_item}')->group(function () {
        //     Route::get('', [CategoryController::class, 'get']);
        //     Route::post('', [CategoryController::class, 'update']);
        //     Route::delete('', [CategoryController::class, 'delete']);
        // });
    });
});
