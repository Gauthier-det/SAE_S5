<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RaidController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Models\User;


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



//mail
Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    // Find user by custom ID
    $user = User::findOrFail($id);

    // Verify hash matches email
    if (hash('sha1', $user->USE_MAIL) !== $hash) {
        return response()->json(['error' => 'Lien invalide'], 400);
    }

    // Mark as verified
    $user->email_verified_at = now();
    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'Email vérifié avec succès !',
        'user_id' => $user->USE_ID
    ]);
})->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

// Resend (also outside - needs auth:sanctum but after verify route)
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'Lien de vérification envoyé !']);
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');

Route::middleware(['auth:sanctum'])->group(function () {

    // Notice page (web browser)
    Route::get('/email/verify', function () {
        return inertia('Auth/Verify') // or view('auth.verify-email')
        ->with('status', session('status'));
    })->name('verification.notice');


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

    // Admin Addresse routes
    Route::get('/addresses', [AddressController::class, 'getAllAddresses']);
    Route::get('/addresses/{id}', [AddressController::class, 'getAddressById'])->whereNumber('id');
    Route::post('/addresses', [AddressController::class, 'createAddress']);
    Route::put('/addresses/{id}', [AddressController::class, 'updateAddress'])->whereNumber('id');
    Route::delete('/addresses/{id}', [AddressController::class, 'deleteAddress'])->whereNumber('id');

    // Admin User routes
    Route::get('/users', [UserController::class, 'getAllUsers']);
    Route::get('/users/{id}', [UserController::class, 'getUserById'])->whereNumber('id');
    Route::post('/users/{id}', [UserController::class, 'createUser'])->whereNumber('id');
});
