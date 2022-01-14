<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

Route::namespace('Api')->group(static function () {
    Route::prefix('categories')->group(function () {
        Route::get('', [CategoryController::class, 'index']);
        Route::post('', [CategoryController::class, 'store'])->middleware('is_admin');
        Route::prefix('{category_item}')->group(function () {
            Route::get('', [CategoryController::class, 'get']);
            Route::post('', [CategoryController::class, 'update'])->middleware('is_admin');
            Route::delete('', [CategoryController::class, 'delete'])->middleware('is_admin');
        });
    });
});
