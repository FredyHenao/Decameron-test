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

//Rutas del Auth
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
    });
});

//Rutas del usuario
Route::group(['prefix' => 'user'], function () {
    Route::get('all', 'AuthController@user');
    Route::get('show/{id?}', 'AuthController@userShow');
    Route::delete('delete/{id?}', 'AuthController@userDelete');
    Route::group(['middleware' => 'auth:api'], function() {
    });
});

//Rutas de las habitaciones
Route::group(['prefix' => 'room'], function () {
    $controller = "\\App\\Container\\Decameron\\Src\\Controllers\\";

    Route::get('index', $controller.'TypeRoomController@getAll');
    Route::get('accommodations/{id?}', $controller.'TypeRoomController@getAccommodation');
});

//Rutas del hotel
Route::group(['prefix' => 'hotel'], function () {
    $controller = "\\App\\Container\\Decameron\\Src\\Controllers\\";

    Route::post('store', $controller.'HotelController@store');
    Route::post('storeRoom', $controller.'HotelController@storeTypeRoom');
    Route::get('show/{id?}', $controller.'HotelController@getHotel');
    Route::get('index', $controller.'HotelController@allHotels');
    Route::delete('delete/{id?}', $controller.'HotelController@deleteHotel');
    Route::put('update/{id?}', $controller.'HotelController@update');

    Route::group(['prefix' => 'room'], function () {
        $controller = "\\App\\Container\\Decameron\\Src\\Controllers\\";
        Route::post('store', $controller.'HotelController@storeRoomHotel');
        Route::delete('delete/{id?}/{id_relation?}', $controller.'HotelController@deleteHotelRoom');
    });
});
