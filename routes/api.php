<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

Route::group(['prefix' => 'rooms'], function () {
    $controller = "\\App\\Container\\Decameron\\Src\\Controllers\\";

    Route::get('all', $controller.'TypeRoomController@getAll');
    Route::get('accommodatios', $controller.'TypeRoomController@getAccommodation');
});

Route::group(['prefix' => 'hotel'], function () {
    $controller = "\\App\\Container\\Decameron\\Src\\Controllers\\";

    Route::post('store', $controller.'HotelController@store');
    Route::post('storeRoom', $controller.'HotelController@storeTypeRoom');
    Route::post('index', $controller.'HotelController@getHotel');
});
