<?php

use App\Http\Controllers\ChampionController;
use App\Http\Controllers\UserProfileController;
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

Route::get('/profile/{username}', [UserProfileController::class, 'profile']);

Route::get('champion', [ChampionController::class, 'index']);
Route::get('cached/champion', [ChampionController::class, 'full']);
Route::get('champion/{champion}', [ChampionController::class, 'show']);
Route::get('champion/role/{role}', [ChampionController::class, 'role']);
Route::post('champion', [ChampionController::class, 'store']);
Route::delete('champion/{champion}', [ChampionController::class, 'destroy']);

Route::get('top3/champion', [ChampionController::class, 'top3']);

Route::post('champion/like/{champion}', [ChampionController::class, 'like']);
Route::post('champion/dislike/{champion}', [ChampionController::class, 'dislike']);
