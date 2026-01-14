<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RaidController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\RoleController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);

// Raid routes
Route::get('/raids', [RaidController::class, 'getAllRaids']);
Route::get('/raids/{id}', [RaidController::class, 'getRaidById'])->whereNumber('id');

// Race routes
Route::get('/races', [RaceController::class, 'getAllRaces']);
Route::get('/races/{id}', [RaceController::class, 'getRaceById'])->whereNumber('id');
Route::put('/races/{id}', [RaceController::class, 'updateRace'])->whereNumber('id');
Route::delete('/races/{id}', [RaceController::class, 'deleteRace'])->whereNumber('id');


// Clubs routes
Route::get('/clubs', [ClubController::class, 'getAllClubs']);
Route::post('/clubs', [ClubController::class, 'createClub']);
Route::get('/clubs/{id}', [ClubController::class, 'getClubById'])->whereNumber('id');
Route::put('/clubs/{id}', [ClubController::class, 'updateClub'])->whereNumber('id');
Route::delete('/clubs/{id}', [ClubController::class, 'deleteClub'])->whereNumber('id');
Route::get('/clubs/{clubId}/users', [App\Http\Controllers\UserController::class, 'getUserByClub'])->whereNumber('clubId');


// Users routes
Route::get('/users', [App\Http\Controllers\UserController::class, 'getAllUsers']);
Route::get('/users/{id}', [App\Http\Controllers\UserController::class, 'getUserById'])->whereNumber('id');


Route::middleware(['auth:sanctum'])->group(function () {
    // Auth Raid routes
    Route::post('/raids', [RaidController::class, 'createRaid']);
    Route::put('/raids/{id}', [RaidController::class, 'updateRaid'])->whereNumber('id');
    Route::delete('/raids/{id}', [RaidController::class, 'deleteRaid'])->whereNumber('id');
    Route::get('/raids/{raidId}/races', [RaceController::class, 'getRacesByRaid'])->whereNumber('raidId');

    // Auth Races routes
    Route::post('/races', [RaceController::class, 'createRace']);
    Route::put('/races/{id}', [RaceController::class, 'updateRace'])->whereNumber('id');
    Route::delete('/races/{id}', [RaceController::class, 'deleteRace'])->whereNumber('id');
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // Admin Role routes
    Route::get('/roles', [RoleController::class, 'getAllRoles']);
    Route::post('/roles', [RoleController::class, 'createRole']);
    Route::get('/roles/{id}', [RoleController::class, 'getRoleById'])->whereNumber('id');
    Route::put('/roles/{id}', [RoleController::class, 'updateRole'])->whereNumber('id');
    Route::delete('/roles/{id}', [RoleController::class, 'deleteRole'])->whereNumber('id');
});