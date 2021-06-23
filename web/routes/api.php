<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
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

Route::group(['prefix' => 'api/v1', 'middleware' => 'guest'], function () {
    Route::post('register', [RegisterController::class, 'register'])->name('api.auth.register');
    Route::post('login', [LoginController::class, 'login'])->name('api.auth.login');
});

Route::group(['prefix' => 'api/v1', 'middleware' => 'auth:api'], function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('api.auth.logout');
    Route::get('me', [UserController::class, 'profile'])->name('api.me');
    Route::patch('me', [UserController::class, 'updateMe'])->name('api.me.update');
    Route::apiResource('users', UserController::class)
        ->only(['index', 'show', 'store', 'update',])
        ->names([
            'index' => 'api.users.index',
            'show' => 'api.users.show',
            'store' => 'api.users.store',
            'update' => 'api.users.update',
        ]);
    Route::patch('password/update', [UserController::class, 'updatePassword'])->name('api.password.update');
});
