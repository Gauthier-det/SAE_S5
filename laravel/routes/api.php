<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RaidController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;


// Authentication routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);

// Raid routes
Route::get('/raids', [RaidController::class, 'getAllRaids']);
Route::get('/raids/{id}', [RaidController::class, 'getRaidById'])->whereNumber('id');
Route::get('/raids/{raidId}/races', [RaceController::class, 'getRacesByRaid'])->whereNumber('raidId');

// Race routes
Route::get('/races', [RaceController::class, 'getAllRaces']);
Route::get('/races/{id}', [RaceController::class, 'getRaceById'])->whereNumber('id');
Route::get('/races/{id}/details', [RaceController::class, 'getRaceDetails'])->whereNumber('id');
Route::get('/races/{raceId}/results', [RaceController::class, 'getRaceResults'])->whereNumber('raceId');
Route::get('/races/{raceId}/prices', [RaceController::class, 'getRacePrices'])->whereNumber('raceId');

// Club routes
Route::get('/clubs', [ClubController::class, 'getAllClubs']);
Route::get('/clubs/{id}', [ClubController::class, 'getClubById'])->whereNumber('id');
Route::get('/clubs/{clubId}/users', [UserController::class, 'getUsersByClub'])->whereNumber('clubId');

Route::middleware(['auth:sanctum'])->group(function () {
    // Auth Raid routes
    Route::post('/raids', [RaidController::class, 'createRaid']);
    Route::put('/raids/{id}', [RaidController::class, 'updateRaid'])->whereNumber('id');
    Route::delete('/raids/{id}', [RaidController::class, 'deleteRaid'])->whereNumber('id');

    // Auth Race routes
    Route::post('/races', [RaceController::class, 'createRace']);
    Route::post('/races/with-prices', [RaceController::class, 'createRaceWithPrices']);
    Route::put('/races/{id}', [RaceController::class, 'updateRace'])->whereNumber('id');
    Route::delete('/races/{id}', [RaceController::class, 'deleteRace'])->whereNumber('id');

    // Auth User routes
    Route::get('/user', [UserController::class, 'getUserInfo']);
    Route::get('/users', [UserController::class, 'getAllUsers']);
    Route::get('/users/{id}', [UserController::class, 'getUserById']);
    Route::put('/users/{id}', [UserController::class, 'updateUser']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
  
    // Team routes
    Route::post('/teams', [TeamController::class, 'createTeam']);
    Route::post('/teams/addMember', [TeamController::class, 'addMember']);
    Route::get('/races/{raceId}/available-users', [TeamController::class, 'getAvailableUsersForRace'])->whereNumber('raceId');
    Route::post('/teams/{teamId}/register-race', [TeamController::class, 'registerTeamToRace'])->whereNumber('teamId');

    // Address routes
    Route::get('/addresses/{id}', [AddressController::class, 'getAddressById'])->whereNumber('id');
    Route::post('/addresses', [AddressController::class, 'createAddress']);
    Route::put('/addresses/{id}', [AddressController::class, 'updateAddress'])->whereNumber('id');
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // Admin Role routes
    Route::get('/roles', [RoleController::class, 'getAllRoles']);
    Route::post('/roles', [RoleController::class, 'createRole']);
    Route::get('/roles/{id}', [RoleController::class, 'getRoleById'])->whereNumber('id');
    Route::put('/roles/{id}', [RoleController::class, 'updateRole'])->whereNumber('id');
    Route::delete('/roles/{id}', [RoleController::class, 'deleteRole'])->whereNumber('id');

    // Admin Club routes
    Route::post('/clubs', [ClubController::class, 'createClub']);
    Route::post('/clubs/with-address', [ClubController::class, 'createClubWithAddress']);
    Route::put('/clubs/{id}', [ClubController::class, 'updateClub'])->whereNumber('id');
    Route::delete('/clubs/{id}', [ClubController::class, 'deleteClub'])->whereNumber('id');

    // Admin User routes
    Route::get('/users', [UserController::class, 'getAllUsers']);
    Route::get('/users/{id}', [UserController::class, 'getUserById'])->whereNumber('id');
    Route::post('/users/{id}', [UserController::class, 'createUser'])->whereNumber('id');
    
    // Admin Address routes (Delete/GetAll remain admin only)
    Route::get('/addresses', [AddressController::class, 'getAllAddresses']);
    Route::delete('/addresses/{id}', [AddressController::class, 'deleteAddress'])->whereNumber('id');
});
