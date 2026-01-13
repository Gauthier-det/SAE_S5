<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RaidController;
use App\Http\Controllers\RaceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Raid routes
Route::get('/raids', [RaidController::class, 'getRaids']);
Route::get('/raids/{id}', [RaidController::class, 'getRaidById'])->whereNumber('id');
Route::post('/raids/create', [RaidController::class, 'createRaids']);

// Races routes
Route::get('/races', [RaceController::class, 'getAllRaces']);
Route::get('/races/{id}', [RaceController::class, 'getRaceById'])->whereNumber('id');
Route::post('/races', [RaceController::class, 'createRace']);