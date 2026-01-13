<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RaidController;
use App\Http\Controllers\RaceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Raid routes
Route::get('/raids', [RaidController::class, 'getAllRaids']);
Route::get('/raids/{id}', [RaidController::class, 'getRaidById'])->whereNumber('id');
Route::post('/raids', [RaidController::class, 'createRaid']);
Route::put('/raids/{id}', [RaidController::class, 'updateRaid'])->whereNumber('id');
Route::delete('/raids/{id}', [RaidController::class, 'deleteRaid'])->whereNumber('id');

// Races routes
Route::get('/races', [RaceController::class, 'getAllRaces']);
Route::get('/races/{id}', [RaceController::class, 'getRaceById'])->whereNumber('id');
Route::post('/races', [RaceController::class, 'createRace']);