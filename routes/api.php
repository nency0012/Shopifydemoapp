<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::group(['middleware' => ['auth.shopify.custom']], function () {
//    Route::post('/shopify-domain/get_api_key', [\App\Http\Controllers\ShopifyController::class, 'getApiKey']);
//    Route::post('validate/domain', [\App\Http\Controllers\ShopifyController::class, 'validateDomainAccess']);
//
//});

Route::post('/shopify-domain/get_api_key', [\App\Http\Controllers\ShopifyController::class, 'getApiKey']);
   Route::post('validate/domain', [\App\Http\Controllers\ShopifyController::class, 'validateDomainAccess']);

Route::group(['prefix'=>'order'],function (){
    Route::get('list',[\App\Http\Controllers\OrderController::class,'listOrders']);
});

Route::group(['prefix'=>'customer'],function (){
    Route::get('list',[\App\Http\Controllers\CustomerController::class,'listCustomers']);
    Route::post('create', [\App\Http\Controllers\CustomerController::class,'addCustomer']);
     Route::put('update',[\App\Http\Controllers\CustomerController::class,'updateCustomer']);
    Route::delete('delete/{customerId}',[\App\Http\Controllers\CustomerController::class,'deleteCustomer']);
});
