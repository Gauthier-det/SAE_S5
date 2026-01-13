<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RaidController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Raid routes
Route::get('/raids', [RaidController::class, 'getRaids']);
Route::get('/raids/{id}', [RaidController::class, 'getRaidById'])->whereNumber('id');
Route::post('/raids/create', [RaidController::class, 'createRaids']);