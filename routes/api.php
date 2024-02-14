<?php

use App\Http\Controllers\ChampionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);
Route::get('me', [App\Http\Controllers\AuthController::class, 'me']);
Route::post('register', [App\Http\Controllers\AuthController::class, 'register']);

Route::resource('champion', ChampionController::class);
