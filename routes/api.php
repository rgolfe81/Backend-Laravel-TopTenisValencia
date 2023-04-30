<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\TennisMatchController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Users
Route::group([
    'middleware' => 'auth:sanctum'
    ], function () {
        Route::get('/users/profile', [UserController::class, 'profile']);
        Route::put('/users/{id}', [UserController::class, 'updateUser']);
});
Route::group([
    'middleware' => ['auth:sanctum', 'isAdmin']
    ], function () {
    Route::get('/users', [UserController::class, 'getAllUsers']);
});

// Tournaments
Route::get('/tournaments', [TournamentController::class, 'getAllTournaments']);
Route::get('/tournament/{id}', [TournamentController::class, 'getTournamentById']);
Route::group([
    'middleware' => ['auth:sanctum', 'isAdmin']
    ], function () {
    Route::post('/tournaments', [TournamentController::class, 'createTournament']);
    Route::put('/tournaments/{id}', [TournamentController::class, 'updateTournament']);
    Route::delete('/tournaments/{id}', [TournamentController::class, 'deleteTournament']);
    Route::delete('/tournaments/{id}', [TournamentController::class, 'deleteUserToTournamentId']);
    });
Route::group([
    'middleware' => 'auth:sanctum'
    ], function () {
        Route::post('/tournaments/{id}', [TournamentController::class, 'addUserToTournamentId']);
        Route::get('/tournaments/{id}', [TournamentController::class, 'getUsersbyTournamentId']);
    });

// TennisMatches
Route::group([
    'middleware' => ['auth:sanctum', 'isAdmin']
    ], function () {
    Route::post('/tennisMatches/{id}', [TennisMatchController::class, 'createMatchToTournamentId']);
    Route::put('/tennisMatches/{id}', [TennisMatchController::class, 'updateTennisMatchById']);
    Route::delete('/tennisMatches/{id}', [TennisMatchController::class, 'deleteTennisMatchById']);
    });
Route::group([
    'middleware' => 'auth:sanctum'
    ], function () {
        Route::get('/tennisMatches/{id}', [TennisMatchController::class, 'getMatchesbyTournamentId']);
    });

// Results
Route::group([
    'middleware' => 'auth:sanctum'
    ], function () {
Route::put('/results/{id}', [ResultController::class, 'updateResultbyIdToTennisMatch']);
Route::get('/results/{id}', [ResultController::class, 'getResultsByTournamentId']);
Route::get('/resultsForWinner/{id}', [ResultController::class, 'getResultsByTournamentIdForWinner']);
    });
Route::group([
    'middleware' => ['auth:sanctum', 'isAdmin']
    ], function () {
Route::get('/resultsForWinners/{id}', [ResultController::class, 'getResultsByTournamentIdForWinners']);  
});

// Classification
Route::get('/classification/{id}', [ClassificationController::class, 'getClassificationByTournamentId']);
