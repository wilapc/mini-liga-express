<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\StandingsController;

Route::get('/teams', [TeamController::class, 'index']);
Route::post('/teams', [TeamController::class, 'store']);
Route::post('/games/{id}/result', [GameController::class, 'result']);
Route::get('/standings', [StandingsController::class, 'index']);
