<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['before' => '/{any}', 'where' => ['any' => '.*']], function () {
    Route::get('/{any}', function () {
        return view('welcome');
    })->where('any', '.*');
    Route::prefix('order')->group(static function () {
        Route::prefix('{order}/{fileId}')->group(static function () {
            Route::get('/', 'FileController@order')->name('files.orders');
        });
    });
});


