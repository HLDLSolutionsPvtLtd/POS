<?php

use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(ProductController::class)->group(function(){
    Route::get('/{store:id}/products/all', 'index');
    Route::get('/{store:id}/products/search', 'search');
});

Route::controller(OrderController::class)->group(function(){
    Route::post('/{store:id}/order/create', 'create');
    Route::get('/fetch/qr', 'fetchQr');
    Route::get('/check/payment', 'checkPayment');
    Route::post('/orders/{sale:id}/return', 'returnOrder');
    Route::get('/{store:id}/orders', 'index');
    Route::get('/order/fetch', 'order');
    Route::get('/receipt/{sale:id}/print', 'printReceipt');
    Route::get('/orders/search', 'search');
});

Route::controller(OrderController::class)->group(function(){
    Route::post('/payment/callback', 'callback');
});

Route::controller(UserController::class)->group(function(){
    Route::post('/login', 'authenticate');
});
