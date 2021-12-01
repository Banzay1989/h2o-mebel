<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::namespace('Api')->group(static function () {
    Route::prefix('orders')->group(function () {
        Route::get('', [OrderController::class, 'index']);
        Route::get('const', [OrderController::class, 'getConsts']);
        // Route::get('byFlow', [EquipmentsController::class, 'byFlow']);
        // Route::post('', [EquipmentsController::class, 'store']);
        // Route::prefix('{equipment}')->group(function () {
        //     Route::put('', [EquipmentsController::class, 'update']);
        //     Route::delete('', [EquipmentsController::class, 'destroy']);
        // });
    });
});
