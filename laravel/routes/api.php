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
Route::post('/', [RaidController::class, 'createRaid']);

// Races routes
Route::post('/', [RaceController::class, 'createRace']);

// Roles routes
Route::middleware(['auth', 'admin'])->prefix('roles')->name('roles')->group(function () {
    Route::get('/', [RoleController::class, 'getAllRoles']);
    Route::get('/{id}', [RoleController::class, 'getRoleById'])->whereNumber('id');
    Route::post('/', [RoleController::class, 'createRole']);
});