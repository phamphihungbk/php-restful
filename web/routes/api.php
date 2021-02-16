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
    Route::get('users', ['uses' => 'UserController@index']);
    Route::get('users/{email}', ['uses' => 'UserController@show']);
    Route::post('users', ['uses' => 'UserController@store']);
    Route::put('users/{email}', ['uses' => 'UserController@update']);
    Route::delete('users/{email}', ['uses' => 'UserController@destroy']);
});
