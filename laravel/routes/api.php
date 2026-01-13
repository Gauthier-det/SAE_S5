<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RaidController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\RoleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Home routes
Route::get('/races', [RaceController::class, 'getAllRaces']);
Route::get('/races/{id}', [RaceController::class, 'getRaceById'])->whereNumber('id');
Route::get('/raids', [RaidController::class, 'getAllRaids']);
Route::get('/raids/{id}', [RaidController::class, 'getRaidById'])->whereNumber('id');

// Raid routes
Route::middleware(['Authenticate', 'ClubManager'])->prefix('raids')->name('raids')->group(function () {
    Route::post('/', [RaidController::class, 'createRaid']);
});

// Races routes
Route::middleware(['Authenticate', 'RaidManager'])->prefix('races')->name('races')->group(function () {
    Route::post('/', [RaceController::class, 'createRace']);
});

// Roles routes
Route::middleware(['Authenticate', 'SiteManager'])->prefix('roles')->name('roles')->group(function () {
    Route::get('/', [RaceController::class, 'getAllRoles']);
    Route::get('/{id}', [RaceController::class, 'getRoleById'])->whereNumber('id');
    Route::post('/', [RaceController::class, 'createRole']);
});