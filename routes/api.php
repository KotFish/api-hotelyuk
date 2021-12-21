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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('reservations/{user_id}', 'Api\ReservationsController@index');
    Route::post('reservations/{user_id}', 'Api\ReservationsController@store');
    Route::put('reservations/{id}', 'Api\ReservationsController@update');
    Route::delete('reservations/{id}', 'Api\ReservationsController@destroy');

    Route::get('user/{user_id}', 'Api\AuthController@showUser');
    Route::put('user/{user_id}', 'Api\AuthController@editUser');

    Route::get('review/{user_id}', 'Api\ReviewController@index');
    Route::post('review/{user_id}', 'Api\ReviewController@store');
    Route::put('review/{id}', 'Api\ReviewController@update');
    Route::delete('review/{id}', 'Api\ReviewController@destroy');
});