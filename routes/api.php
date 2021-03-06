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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('teams_tournament', [\App\Http\Controllers\TeamController::class, 'tournamentTeams']);

Route::get('matches', [\App\Http\Controllers\MatchController::class, 'all']);

Route::post('save_result', [\App\Http\Controllers\ResultController::class, 'store']);
Route::post('save_results', [\App\Http\Controllers\ResultController::class, 'massiveStore']);
