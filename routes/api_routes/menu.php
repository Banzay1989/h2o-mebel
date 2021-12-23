<?php

use App\Http\Controllers\Api\MenuItemController;
use Illuminate\Support\Facades\Route;

Route::namespace('Api')->group(static function () {
    Route::prefix('menu')->group(function () {
        Route::get('', [MenuItemController::class, 'index']);
        // Route::get('const', [OrderController::class, 'getConsts']);
        Route::post('', [MenuItemController::class, 'store']);
        Route::prefix('{menu_item}')->group(function () {
            Route::get('', [MenuItemController::class, 'get']);
            Route::post('', [MenuItemController::class, 'update']);
            Route::delete('', [MenuItemController::class, 'delete']);
        });
    });
});
