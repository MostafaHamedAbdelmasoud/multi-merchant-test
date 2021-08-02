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

Route::group([
    'namespace' => 'Auth',
], function () {
    Route::group([
        'prefix' => 'admin',
    ], function () {
        Route::post('/login', 'AdminApiController@login');
        Route::post('/logout', 'AdminApiController@logout');
    });


});


Route::group([
    'namespace' => 'Auth',
], function () {
    Route::group([
        'prefix' => 'customer',
    ], function () {
        Route::post('register', 'CustomerApiAuthController@register');
        Route::post('login', 'CustomerApiAuthController@login');
        Route::post('logout', 'CustomerApiAuthController@logout');

        Route::post('forget-password', 'CustomerApiAuthController@forgetPassword');
        Route::post('reset-password', 'CustomerApiAuthController@resetPassword');
        Route::post('change-password', 'CustomerApiAuthController@changePassword');
        Route::post('check-code', 'CustomerApiAuthController@checkCode');

        Route::post('confirm', 'VerificationController@confirmPhone');
        Route::post('resend-code', 'VerificationController@resend');
        Route::post('update-phone', 'VerificationController@updatePhone');

        Route::get('get', 'CustomerApiController@get');
        Route::post('update', 'CustomerApiController@update');
        Route::get('all', 'CustomerApiController@index');
    });
});


Route::group([
    'prefix' => 'store',
    'namespace' => 'Store',
], function () {
    Route::get('all', 'StoreApiController@all');
    Route::get('get', 'StoreApiController@read');
    Route::post('create', 'StoreApiController@create');
    Route::post('edit', 'StoreApiController@edit');
    Route::delete('delete', 'StoreApiController@delete');
});


Route::group([
    'namespace' => 'Division',
], function () {
    Route::group([
        'prefix' => 'category',
    ], function () {
        Route::get('all', 'CategoryApiController@all');
        Route::get('get', 'CategoryApiController@read');
        Route::delete('delete', 'CategoryApiController@delete');
        Route::post('create', 'CategoryApiController@create');
        Route::post('edit', 'CategoryApiController@edit');
    });

    Route::group([
        'prefix' => 'tag',
    ], function () {
        Route::get('all', 'TagApiController@all');
        Route::get('get', 'TagApiController@read');
        Route::post('create', 'TagApiController@create');
        Route::post('edit', 'TagApiController@edit');
        Route::delete('delete', 'TagApiController@delete');
    });


});


Route::group([
    'prefix' => 'product',
    'namespace' => 'Product',
], function () {
    Route::get('all', 'ProductApiController@all');
    Route::get('offers', 'ProductApiController@offers');
    Route::get('get', 'ProductApiController@read');
    Route::post('create', 'ProductApiController@create');
    Route::post('update', 'ProductApiController@edit');
    Route::delete('delete', 'ProductApiController@delete');
    Route::get('price-range', 'ProductApiController@priceRange');
});


Route::group([
    'namespace' => 'Order',
], function () {

    Route::group([
        'prefix' => 'cart',
    ], function () {
        Route::post('add-to-cart', 'CartApiController@addToCart');
        Route::post('delete', 'CartApiController@delete');
        Route::post('update', 'CartApiController@update');
        Route::get('all', 'CartApiController@index');
    });

});


