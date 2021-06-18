<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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
Route::group(['prefix' => 'api/v1'], function () {
    Route::post('register', [RegisterController::class, 'register'])->name('api.auth.register');
    Route::post('login', [LoginController::class, 'login'])->name('api.auth.login');
});

###################
# JUST AUTH
###################

Route::group(['prefix' => 'api/v1'], function () {
    Route::post('logout', [LoginController::class, 'logout'])
        ->name('api.auth.logout');
});
