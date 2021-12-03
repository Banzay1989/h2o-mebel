<?php

use App\Http\RestApi\ApiOrder;
use Illuminate\Support\Facades\Route;

Route::namespace('Api')->group(static function () {
    Route::prefix('rest_api')->group(function () {
        Route::prefix('orders')->group(function () {
            Route::get('', [ApiOrder::class, 'index']);
            Route::post('', [ApiOrder::class, 'store']);
            Route::prefix('{order}')->group(function () {
                Route::get('', [ApiOrder::class, 'get']);
                Route::put('', [ApiOrder::class, 'update']);
                Route::delete('', [ApiOrder::class, 'delete']);
            });
        });
    });
});
