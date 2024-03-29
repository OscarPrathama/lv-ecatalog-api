<?php

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\UserController;
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

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('users/profile', [UserController::class, 'myProfile']);
    Route::resource('users', UserController::class);
    Route::resource('posts', PostController::class)->except('update');
    Route::put('posts/{id}', [PostController::class, 'update'])->name('posts.update');

    Route::post('logout', [LoginController::class, 'logout']);
});

