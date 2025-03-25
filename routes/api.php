<?php

use App\Http\Controllers\TournoisController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\MatchesController;
use App\Models\Matches;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:api');
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::apiResource('tournois', TournoisController::class);
Route::apiResource('players', PlayersController::class);
Route::apiResource('matches', MatchesController::class);
Route::post('/players/{id}/assign-match', [PlayersController::class, 'assignToMatch']);
Route::post('/players/{player_id}/remove-from-match/{match_id}', [PlayersController::class, 'removeFromMatch']);
Route::get('/matches/{id}/players', [MatchesController::class, 'getMatchPlayers']);

