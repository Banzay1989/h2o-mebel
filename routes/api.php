<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// require_once 'api_routes/order.php';
require_once 'api_routes/product.php';
require_once 'api_routes/menu.php';
require_once 'api_routes/categories.php';
require_once 'api_routes/brands.php';

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

