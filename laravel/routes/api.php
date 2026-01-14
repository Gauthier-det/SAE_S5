<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RaidController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\AddressController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);


// Raid routes
Route::get('/raids', [RaidController::class, 'getAllRaids']);
Route::post('/raids', [RaidController::class, 'createRaid']);
Route::get('/raids/{id}', [RaidController::class, 'getRaidById'])->whereNumber('id');
Route::put('/raids/{id}', [RaidController::class, 'updateRaid'])->whereNumber('id');
Route::delete('/raids/{id}', [RaidController::class, 'deleteRaid'])->whereNumber('id');
Route::get('/raids/{raidId}/races', [RaceController::class, 'getRacesByRaid'])->whereNumber('raidId');

// Races routes
Route::get('/races', [RaceController::class, 'getAllRaces']);
Route::post('/races', [RaceController::class, 'createRace']);
Route::get('/races/{id}', [RaceController::class, 'getRaceById'])->whereNumber('id');
Route::put('/races/{id}', [RaceController::class, 'updateRace'])->whereNumber('id');
Route::delete('/races/{id}', [RaceController::class, 'deleteRace'])->whereNumber('id');


// Clubs routes
Route::get('/clubs', [ClubController::class, 'getAllClubs']);
Route::post('/clubs', [ClubController::class, 'createClub']);
Route::get('/clubs/{id}', [ClubController::class, 'getClubById'])->whereNumber('id');
Route::put('/clubs/{id}', [ClubController::class, 'updateClub'])->whereNumber('id');
Route::delete('/clubs/{id}', [ClubController::class, 'deleteClub'])->whereNumber('id');


// Addresses routes
Route::get('/addresses', [AddressController::class, 'getAllAddresses']);
Route::get('/addresses/{id}', [AddressController::class, 'getAddressById'])->whereNumber('id');
Route::post('/addresses', [AddressController::class, 'createAddress']);
Route::put('/addresses/{id}', [AddressController::class, 'updateAddress'])->whereNumber('id');
Route::delete('/addresses/{id}', [AddressController::class, 'deleteAddress'])->whereNumber('id');