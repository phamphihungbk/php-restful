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

Route::get('users', 'Api\UserController@index')->name('users.index');
Route::get('users/{id}', 'Api\UserController@show')->name('users.show');
Route::post('users', 'Api\UserController@store')->name('users.store');
Route::put('users/{id}', 'Api\UserController@update')->name('users.update');
Route::patch('users/{id}', 'Api\UserController@update')->name('users.update');
Route::delete('users/{id}', 'Api\UserController@destroy')->name('users.destroy');
