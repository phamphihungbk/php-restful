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

Route::group(['prefix' => 'api/v1'], function () {
    Route::get('users', 'App\Http\Controllers\UserController@index')->name('users.index');
    Route::get('users/{id}', 'App\Http\Controllers\UserController@show')->name('users.show');
    Route::post('users', 'App\Http\Controllers\UserController@store')->name('users.store');
    Route::put('users/{id}', 'App\Http\Controllers\UserController@update')->name('users.update');
//    Route::patch('users/{id}', 'App\Http\Controllers\UserController@update')->name('users.update');
    Route::delete('users/{id}', 'App\Http\Controllers\UserController@destroy')->name('users.destroy');
});
