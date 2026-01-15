<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RaidController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;

/**
 * Reset the database and seed it with initial data
 * This endpoint is for development purposes only
 */
Route::get('/reset', function () {
    Artisan::call('migrate:fresh', [
        '--seed' => true,
        '--force' => true
    ]);
    return response()->json(['message' => 'Database reset and seeded successfully']);
});

/**
 * @group Authentication
 * Authenticate a user and return an access token
 * @bodyParam mail string required The user's email address. Example: admin.site@example.com
 * @bodyParam password string required The user's password. Example: pwd123
 * @response 201 {
 *   "data": {
 *     "user_id": 1,
 *     "user_name": "Admin",
 *     "user_last_name": "Site",
 *     "user_mail": "admin.site@example.com",
 *     "user_gender": "Homme",
 *     "user_phone": null,
 *     "user_birthdate": null,
 *     "user_licence": null,
 *     "user_membership_date": "2024-01-01",
 *     "user_validity": "2025-01-01",
 *     "user_address": {...},
 *     "user_club": {...},
 *     "access_token": "1|abc123...",
 *     "token_type": "Bearer"
 *   }
 * }
 * @response 401 {
 *   "message": "Invalid credentials"
 * }
 */
Route::post('/login', [AuthController::class, 'login'])->name('login');

/**
 * @group Authentication
 * Logout the authenticated user by revoking their tokens
 * @authenticated
 * @response 200 {
 *   "message": "Logged out successfully"
 * }
 */
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

/**
 * @group Authentication
 * Register a new user account
 * @bodyParam mail string required The user's email address. Example: newuser@example.com
 * @bodyParam password string required The user's password (min 8 characters). Example: password123
 * @bodyParam name string required The user's first name. Example: John
 * @bodyParam last_name string required The user's last name. Example: Doe
 * @bodyParam gender string required The user's gender. Must be one of: Homme, Femme, Autre. Example: Homme
 * @response 201 {
 *   "data": {
 *     "user_id": 1,
 *     "user_name": "John",
 *     "user_last_name": "Doe",
 *     "user_mail": "newuser@example.com",
 *     "user_gender": "Homme",
 *     "access_token": "1|abc123...",
 *     "token_type": "Bearer"
 *   }
 * }
 * @response 422 {
 *   "message": "Validation failed",
 *   "errors": {...}
 * }
 */
Route::post('/register', [AuthController::class, 'register']);

// Raid routes
/**
 * @group Raids
 * Get all raids
 * @response 200 {
 *   "data": [
 *     {
 *       "RAI_ID": 1,
 *       "RAI_NAME": "Raid Example",
 *       "RAI_TIME_START": "2025-10-10 08:30:00",
 *       "RAI_TIME_END": "2025-10-10 13:30:00",
 *       "club": {...},
 *       "address": {...},
 *       "user": {...}
 *     }
 *   ]
 * }
 */
Route::get('/raids', [RaidController::class, 'getAllRaids']);

/**
 * @group Raids
 * Get a specific raid by ID
 * @urlParam id integer required The raid ID. Example: 1
 * @response 200 {
 *   "data": {
 *     "RAI_ID": 1,
 *     "RAI_NAME": "Raid Example",
 *     "RAI_TIME_START": "2025-10-10 08:30:00",
 *     "RAI_TIME_END": "2025-10-10 13:30:00",
 *     "club": {...},
 *     "address": {...},
 *     "user": {...}
 *   }
 * }
 * @response 404 {
 *   "message": "Raid not found"
 * }
 */
Route::get('/raids/{id}', [RaidController::class, 'getRaidById'])->whereNumber('id');

/**
 * @group Raids
 * Get all races for a specific raid
 * @urlParam raidId integer required The raid ID. Example: 1
 * @response 200 {
 *   "data": [
 *     {
 *       "RAC_ID": 1,
 *       "RAC_NAME": "Trail Mixte Loisir",
 *       "RAC_TIME_START": "2025-10-10 08:30:00",
 *       "RAC_TIME_END": "2025-10-10 13:30:00",
 *       "user": {...}
 *     }
 *   ]
 * }
 */
Route::get('/raids/{raidId}/races', [RaceController::class, 'getRacesByRaid'])->whereNumber('raidId');

// Race routes
/**
 * @group Races
 * Get all races
 * @response 200 {
 *   "data": [
 *     {
 *       "RAC_ID": 1,
 *       "RAC_NAME": "Trail Mixte Loisir",
 *       "RAC_TIME_START": "2025-10-10 08:30:00",
 *       "RAC_TIME_END": "2025-10-10 13:30:00",
 *       "user": {...},
 *       "raid": {...}
 *     }
 *   ]
 * }
 */
Route::get('/races', [RaceController::class, 'getAllRaces']);

/**
 * @group Races
 * Get a specific race by ID
 * @urlParam id integer required The race ID. Example: 1
 * @response 200 {
 *   "data": {
 *     "RAC_ID": 1,
 *     "RAC_NAME": "Trail Mixte Loisir",
 *     "RAC_TIME_START": "2025-10-10 08:30:00",
 *     "RAC_TIME_END": "2025-10-10 13:30:00"
 *   }
 * }
 * @response 404 {
 *   "message": "Race not found"
 * }
 */
Route::get('/races/{id}', [RaceController::class, 'getRaceById'])->whereNumber('id');

/**
 * @group Races
 * Get detailed information about a race including teams and results
 * @urlParam id integer required The race ID. Example: 1
 * @response 200 {
 *   "data": {
 *     "RAC_ID": 1,
 *     "RAC_NAME": "Trail Mixte Loisir",
 *     "teams": [...],
 *     "results": [...]
 *   }
 * }
 */
Route::get('/races/{id}/details', [RaceController::class, 'getRaceDetails'])->whereNumber('id');

/**
 * @group Races
 * Get the results of a specific race
 * @urlParam raceId integer required The race ID. Example: 1
 * @response 200 {
 *   "data": [
 *     {
 *       "TEA_ID": 1,
 *       "TEA_NAME": "Team Example",
 *       "TER_TIME": "02:30:00",
 *       "TER_IS_VALID": 1
 *     }
 *   ]
 * }
 */
Route::get('/races/{raceId}/results', [RaceController::class, 'getRaceResults'])->whereNumber('raceId');

/**
 * @group Races
 * Get the pricing categories for a specific race
 * @urlParam raceId integer required The race ID. Example: 1
 * @response 200 {
 *   "data": [
 *     {
 *       "CAT_ID": 1,
 *       "CAT_LABEL": "Senior",
 *       "CAR_PRICE": 15.00
 *     }
 *   ]
 * }
 */
Route::get('/races/{raceId}/prices', [RaceController::class, 'getRacePrices'])->whereNumber('raceId');

// Club routes
/**
 * @group Clubs
 * Get all clubs
 * @response 200 {
 *   "data": [
 *     {
 *       "CLU_ID": 1,
 *       "CLU_NAME": "Club Example",
 *       "CLU_DESCRIPTION": "Description...",
 *       "user": {...},
 *       "address": {...}
 *     }
 *   ]
 * }
 */
Route::get('/clubs', [ClubController::class, 'getAllClubs']);

/**
 * @group Clubs
 * Get a specific club by ID
 * @urlParam id integer required The club ID. Example: 1
 * @response 200 {
 *   "data": {
 *     "CLU_ID": 1,
 *     "CLU_NAME": "Club Example",
 *     "CLU_DESCRIPTION": "Description...",
 *     "user": {...},
 *     "address": {...}
 *   }
 * }
 * @response 404 {
 *   "message": "Club not found"
 * }
 */
Route::get('/clubs/{id}', [ClubController::class, 'getClubById'])->whereNumber('id');

/**
 * @group Clubs
 * Get all users belonging to a specific club
 * @urlParam clubId integer required The club ID. Example: 1
 * @response 200 {
 *   "data": [
 *     {
 *       "USE_ID": 1,
 *       "USE_NAME": "John",
 *       "USE_LAST_NAME": "Doe",
 *       "USE_MAIL": "john@example.com"
 *     }
 *   ]
 * }
 */
Route::get('/clubs/{clubId}/users', [UserController::class, 'getUsersByClub'])->whereNumber('clubId');

/**
 * @group Users
 * Get all users who are not assigned to any club (free runners)
 * @response 200 {
 *   "data": [
 *     {
 *       "USE_ID": 1,
 *       "USE_NAME": "John",
 *       "USE_LAST_NAME": "Doe",
 *       "USE_MAIL": "john@example.com"
 *     }
 *   ]
 * }
 */
Route::get('/users/free', [UserController::class, 'getFreeRunners']);

Route::middleware(['auth:sanctum'])->group(function () {
    // Auth Raid routes
    Route::post('/raids', [RaidController::class, 'createRaid']);
    Route::put('/raids/{id}', [RaidController::class, 'updateRaid'])->whereNumber('id');
    Route::delete('/raids/{id}', [RaidController::class, 'deleteRaid'])->whereNumber('id');

    // Auth Race routes
    Route::post('/races', [RaceController::class, 'createRace']);
    Route::post('/races/with-prices', [RaceController::class, 'createRaceWithPrices']);
    Route::post('/races/{raceId}/team-results', [RaceController::class, 'storeTeamRaceResult'])->whereNumber('raceId');
    Route::put('/races/{id}', [RaceController::class, 'updateRace'])->whereNumber('id');
    Route::delete('/races/{id}', [RaceController::class, 'deleteRace'])->whereNumber('id');
    Route::get('/races/{raceId}/teams', [TeamController::class, 'getTeamsByRace'])->whereNumber('raceId');

    // Auth User routes
    Route::get('/user', [UserController::class, 'getUserInfo']);
    Route::get('/user/is-admin', [UserController::class, 'checkIsAdmin']);
    Route::get('/user/stats/{id}', [UserController::class, 'getUserStats'])->whereNumber('id');
    Route::get('/user/history/{id}', [UserController::class, 'getUserHistory'])->whereNumber('id');
    Route::get('/users', [UserController::class, 'getAllUsers']);
    Route::get('/users/{id}', [UserController::class, 'getUserById']);
    Route::put('/users/{id}', [UserController::class, 'updateUser']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
    Route::post('/users/races/register', [UserController::class, 'registerUserToRace']); //Create an entry in SAN_USERS_RACES

    // Team routes
    Route::post('/teams', [TeamController::class, 'createTeam']);
    Route::post('/teams/addMember', [TeamController::class, 'addMember']);
    Route::get('/races/{raceId}/available-users', [TeamController::class, 'getAvailableUsersForRace'])->whereNumber('raceId');
    Route::post('/teams/{teamId}/register-race', [TeamController::class, 'registerTeamToRace']);
    
    // Team Management
    Route::get('/teams/{teamId}/races/{raceId}', [TeamController::class, 'getTeamRaceDetails']);
    Route::post('/teams/member/remove', [TeamController::class, 'removeMember']);
    Route::post('/teams/member/update-info', [TeamController::class, 'updateMemberRaceInfo']);
    Route::post('/teams/validate-race', [TeamController::class, 'validateTeamForRace']);
    Route::post('/teams/unvalidate-race', [TeamController::class, 'unvalidateTeamForRace']);
    Route::get('/teams/{id}', [TeamController::class, 'getTeamById'])->whereNumber('id');
    Route::get('/teams/{teamId}/users', [UserController::class, 'getUsersByTeam'])->whereNumber('teamId');

    // Address routes
    Route::get('/addresses/{id}', [AddressController::class, 'getAddressById'])->whereNumber('id');
    Route::post('/addresses', [AddressController::class, 'createAddress']);
    Route::put('/addresses/{id}', [AddressController::class, 'updateAddress'])->whereNumber('id');
    Route::put('/addresses/{id}', [AddressController::class, 'updateAddress'])->whereNumber('id');
    
    // Club Member Management
    Route::post('/clubs/{id}/members/add', [ClubController::class, 'addMember'])->whereNumber('id');
    Route::post('/clubs/{id}/members/remove', [ClubController::class, 'removeMember'])->whereNumber('id');
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
    
    Route::delete('/clubs/{id}', [ClubController::class, 'deleteClub'])->whereNumber('id');

    // Admin Addresse routes
    Route::get('/addresses', [AddressController::class, 'getAllAddresses']);
    Route::delete('/addresses/{id}', [AddressController::class, 'deleteAddress'])->whereNumber('id');

    // Admin User routes
    Route::get('/users', [UserController::class, 'getAllUsers']);
    Route::get('/users/{id}', [UserController::class, 'getUserById'])->whereNumber('id');
    Route::post('/users/{id}', [UserController::class, 'createUser'])->whereNumber('id');
    
    // Admin Address routes (Delete/GetAll remain admin only)
    Route::get('/addresses', [AddressController::class, 'getAllAddresses']);
    Route::delete('/addresses/{id}', [AddressController::class, 'deleteAddress'])->whereNumber('id');
});
