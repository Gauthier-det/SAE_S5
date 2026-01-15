<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Race;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function createTeam(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'image' => 'nullable|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        $team = Team::create([
            'USE_ID' => auth()->id(),
            'TEA_NAME' => $request->name,
            'TEA_IMAGE' => $request->image,
        ]);

        return response()->json(['data' => [
            'team_id' => $team->TEA_ID,
            'team_name' => $team->TEA_NAME,
            'owner_id' => $team->USE_ID,
            'message' => 'Team created successfully',
        ]], 201);
    }

public function addMember(Request $request)
{
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|integer|exists:SAN_USERS,USE_ID',
        'team_id' => 'required|integer|exists:SAN_TEAMS,TEA_ID',
        'race_id' => 'required|integer|exists:SAN_RACES,RAC_ID',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $team = Team::findOrFail($request->team_id);
    if ($team->USE_ID !== auth()->id()) {
        return response()->json(['message' => 'Unauthorized - you did not create this team'], 403);
    }

    $race = Race::findOrFail($request->race_id);
    $user = User::findOrFail($request->user_id);

    // Check if user is old enough for the race
    if ($user->USE_BIRTHDATE) {
        $birthDate = \Carbon\Carbon::parse($user->USE_BIRTHDATE);
        $age = $birthDate->age;
        if ($age < $race->RAC_AGE_MIN) {
            return response()->json([
                'message' => "User is too young for this race. Minimum age required: {$race->RAC_AGE_MIN}, user age: {$age}"
            ], 422);
        }
    }

    // Check for race time conflicts
    $conflictingRace = DB::table('SAN_USERS_RACES')
        ->join('SAN_RACES', 'SAN_USERS_RACES.RAC_ID', '=', 'SAN_RACES.RAC_ID')
        ->where('SAN_USERS_RACES.USE_ID', $request->user_id)
        ->where('SAN_RACES.RAC_ID', '!=', $request->race_id) 
        ->where(function ($query) use ($race) {
            $query->where('SAN_RACES.RAC_TIME_START', '<', $race->RAC_TIME_END)
                  ->where('SAN_RACES.RAC_TIME_END', '>', $race->RAC_TIME_START);
        })
        ->exists();

    if ($conflictingRace) {
        return response()->json(['message' => 'User already registered for a race with overlapping time'], 409);
    }

    // Check if user is already part of the team
    $exists = DB::table('SAN_USERS_TEAMS')
        ->where('USE_ID', $request->user_id)
        ->where('TEA_ID', $request->team_id)
        ->exists();

    if ($exists) {
        return response()->json(['message' => 'User is already part of the team'], 409);
    }

    // Check if team is registered for this race, if not, register it
    $teamRaceExists = DB::table('SAN_TEAMS_RACES')
        ->where('TEA_ID', $request->team_id)
        ->where('RAC_ID', $request->race_id)
        ->exists();

    if (!$teamRaceExists) {
        // Get the next race number for this race
        $maxRaceNumber = DB::table('SAN_TEAMS_RACES')
            ->where('RAC_ID', $request->race_id)
            ->max('TER_RACE_NUMBER') ?? 0;

        // Register team to race
        DB::table('SAN_TEAMS_RACES')->insert([
            'TEA_ID' => $request->team_id,
            'RAC_ID' => $request->race_id,
            'TER_TIME' => null,
            'TER_POINTS' => null,
            'TER_IS_VALID' => 0,
            'TER_RACE_NUMBER' => $maxRaceNumber + 1,
        ]);
    }

    // Add user to team
    DB::table('SAN_USERS_TEAMS')->insert([
        'USE_ID' => $request->user_id,
        'TEA_ID' => $request->team_id,
    ]);

    // Add user to race
    DB::table('SAN_USERS_RACES')->insert([
        'USE_ID' => $request->user_id,
        'RAC_ID' => $request->race_id,
        'USR_CHIP_NUMBER' => null,
        'USR_TIME' => null,
        'USR_PPS_FORM' => null,
    ]);

    return response()->json(['data' => [
        'team_id' => $request->team_id,
        'user_id' => $request->user_id,
        'race_id' => $request->race_id,
        'message' => 'User added to team and race successfully',
    ]], 201);
}


    /**
     * Get users for a specific race with availability status
     * Returns all matching gender users, flagging those unavailable
     */
    public function getAvailableUsersForRace($raceId)
    {
        $race = Race::find($raceId);
        if (!$race) {
            return response()->json(['message' => 'Race not found'], 404);
        }

        // Get users who are in any race with overlapping time
        $unavailableByRaceTime = DB::table('SAN_USERS_RACES')
            ->join('SAN_RACES', 'SAN_USERS_RACES.RAC_ID', '=', 'SAN_RACES.RAC_ID')
            ->where(function ($query) use ($race) {
                $query->where('SAN_RACES.RAC_TIME_START', '<', $race->RAC_TIME_END)
                      ->where('SAN_RACES.RAC_TIME_END', '>', $race->RAC_TIME_START);
            })
            ->pluck('SAN_USERS_RACES.USE_ID')
            ->toArray();

        // Get users who are already in a team registered for this race (or are team owners)
        $unavailableByTeam = DB::table('SAN_USERS_TEAMS')
            ->join('SAN_TEAMS_RACES', 'SAN_USERS_TEAMS.TEA_ID', '=', 'SAN_TEAMS_RACES.TEA_ID')
            ->where('SAN_TEAMS_RACES.RAC_ID', $raceId)
            ->pluck('SAN_USERS_TEAMS.USE_ID')
            ->toArray();

        // Also get team owners who registered teams for this race
        $teamOwners = DB::table('SAN_TEAMS')
            ->join('SAN_TEAMS_RACES', 'SAN_TEAMS.TEA_ID', '=', 'SAN_TEAMS_RACES.TEA_ID')
            ->where('SAN_TEAMS_RACES.RAC_ID', $raceId)
            ->pluck('SAN_TEAMS.USE_ID')
            ->toArray();

        $unavailableByTeam = array_unique(array_merge($unavailableByTeam, $teamOwners));

        // Build query for users matching gender
        $query = User::select('USE_ID', 'USE_NAME', 'USE_LAST_NAME', 'USE_MAIL', 'USE_GENDER');

        // Filter by gender if race is not mixed
        if ($race->RAC_GENDER && $race->RAC_GENDER !== 'Mixte') {
            $query->where('USE_GENDER', $race->RAC_GENDER);
        }

        $users = $query->get()->map(function ($user) use ($unavailableByRaceTime, $unavailableByTeam) {
            $inTeamForRace = in_array($user->USE_ID, $unavailableByTeam);
            $hasOverlappingRace = in_array($user->USE_ID, $unavailableByRaceTime);
            
            return [
                'USE_ID' => $user->USE_ID,
                'USE_NAME' => $user->USE_NAME,
                'USE_LAST_NAME' => $user->USE_LAST_NAME,
                'USE_MAIL' => $user->USE_MAIL,
                'USE_GENDER' => $user->USE_GENDER,
                'is_self' => $user->USE_ID === auth()->id(),
                'already_in_team' => $inTeamForRace,
                'has_overlapping_race' => $hasOverlappingRace,
                'is_available' => !$inTeamForRace && !$hasOverlappingRace,
            ];
        });

        return response()->json(['data' => $users], 200);
    }

    /**
     * Register a team to a race
     */
    public function registerTeamToRace(Request $request, $teamId)
    {
        $request->validate([
            'race_id' => 'required|integer|exists:SAN_RACES,RAC_ID',
        ]);

        $race = Race::findOrFail($request->race_id);
        $raid = $race->raid; // Assuming relationship 'raid' exists in Race model

        // Check registration deadline
        if ($raid && $raid->RAI_REGISTRATION_END && now()->greaterThan($raid->RAI_REGISTRATION_END)) {
             return response()->json(['message' => 'Les inscriptions pour ce raid sont closes.'], 422);
        }

        $team = Team::find($teamId);
        if (!$team) {
            return response()->json(['message' => 'Team not found'], 404);
        }

        // Check ownership
        if ($team->USE_ID !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized - you did not create this team'], 403);
        }

        // Check if already registered
        $exists = DB::table('SAN_TEAMS_RACES')
            ->where('TEA_ID', $teamId)
            ->where('RAC_ID', $request->race_id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Team already registered for this race'], 409);
        }

        // Get the next race number for this race
        $maxRaceNumber = DB::table('SAN_TEAMS_RACES')
            ->where('RAC_ID', $request->race_id)
            ->max('TER_RACE_NUMBER') ?? 0;

        // Insert into SAN_TEAMS_RACES
        DB::table('SAN_TEAMS_RACES')->insert([
            'TEA_ID' => $teamId,
            'RAC_ID' => $request->race_id,
            'TER_TIME' => null,
            'TER_IS_VALID' => 0, // Pending validation
            'TER_RACE_NUMBER' => $maxRaceNumber + 1,
        ]);

        return response()->json(['data' => [
            'team_id' => $teamId,
            'race_id' => $request->race_id,
            'message' => 'Team registered for race successfully',
        ]], 201);
    }

    /**
     * Get team details for a specific race (including members' race info)
     */
    public function getTeamRaceDetails($teamId, $raceId)
    {
        $team = Team::findOrFail($teamId);

        // Check ownership
        if ($team->USE_ID !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $race = Race::findOrFail($raceId);
        
        $teamRace = DB::table('SAN_TEAMS_RACES')
            ->where('TEA_ID', $teamId)
            ->where('RAC_ID', $raceId)
            ->first();

        if (!$teamRace) {
            return response()->json(['message' => 'Team not registered for this race'], 404);
        }

        $members = DB::table('SAN_USERS_TEAMS')
            ->join('SAN_USERS', 'SAN_USERS_TEAMS.USE_ID', '=', 'SAN_USERS.USE_ID')
            ->join('SAN_USERS_RACES', function($join) use ($raceId) {
                $join->on('SAN_USERS.USE_ID', '=', 'SAN_USERS_RACES.USE_ID')
                     ->where('SAN_USERS_RACES.RAC_ID', '=', $raceId);
            })
            ->where('SAN_USERS_TEAMS.TEA_ID', $teamId)
            ->select(
                'SAN_USERS.USE_ID', 
                'SAN_USERS.USE_NAME', 
                'SAN_USERS.USE_LAST_NAME', 
                'SAN_USERS.USE_MAIL',
                'SAN_USERS.USE_LICENCE_NUMBER',
                'SAN_USERS_RACES.USR_CHIP_NUMBER',
                'SAN_USERS_RACES.USR_PPS_FORM' // Correct column name
            )
            ->get();

        return response()->json([
            'team' => [
                'id' => $team->TEA_ID,
                'name' => $team->TEA_NAME,
                'is_valid' => (bool)$teamRace->TER_IS_VALID,
                'race_number' => $teamRace->TER_RACE_NUMBER,
            ],
            'race' => [
                'id' => $race->RAC_ID,
                'type' => $race->RAC_TYPE, // Assuming 'Compétition' or 'Loisir'
            ],
            'members' => $members
        ]);
    }

    /**
     * Remove a member from the team and race
     */
    public function removeMember(Request $request)
    {
        $request->validate([
            'team_id' => 'required|integer',
            'user_id' => 'required|integer',
            'race_id' => 'required|integer',
        ]);

        $team = Team::findOrFail($request->team_id);
        if ($team->USE_ID !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Check if removing self (owner) - prevent if it's the only member or handle gracefully?
        // For now, allow removing any member.

        // Remove from SAN_USERS_TEAMS
        DB::table('SAN_USERS_TEAMS')
            ->where('TEA_ID', $request->team_id)
            ->where('USE_ID', $request->user_id)
            ->delete();

        // Remove from SAN_USERS_RACES
        DB::table('SAN_USERS_RACES')
            ->where('RAC_ID', $request->race_id)
            ->where('USE_ID', $request->user_id)
            ->delete();
            
        return response()->json(['message' => 'Member removed successfully']);
    }

    /**
     * Update member's race info (PPS, Chip)
     */
    public function updateMemberRaceInfo(Request $request)
    {
        $request->validate([
            'team_id' => 'required|integer',
            'race_id' => 'required|integer',
            'user_id' => 'required|integer',
            'chip_number' => 'nullable|string',
            'pps' => 'nullable|string', // Assuming file path string or specialized separate upload handling
        ]);

        $team = Team::findOrFail($request->team_id);
        
        
        $race = Race::findOrFail($request->race_id);

        // Allow owner OR the user themselves OR the Race Manager to update
        if ($team->USE_ID !== auth()->id() && auth()->id() != $request->user_id && $race->USE_ID !== auth()->id()) {
             return response()->json(['message' => 'Unauthorized'], 403);
        }

        DB::table('SAN_USERS_RACES')
            ->where('RAC_ID', $request->race_id)
            ->where('USE_ID', $request->user_id)
            ->update([
                'USR_CHIP_NUMBER' => $request->chip_number,
                'USR_PPS_FORM' => $request->pps 
            ]);
            
        return response()->json(['message' => 'Member info updated']);
    }

    /**
     * Validate the team for the race
     */
    public function validateTeamForRace(Request $request)
    {
        $request->validate([
            'team_id' => 'required|integer',
            'race_id' => 'required|integer',
        ]);

        $team = Team::findOrFail($request->team_id);
        $race = Race::findOrFail($request->race_id);

        // Allow Race Manager
        if ($race->USE_ID !== auth()->id()) {
             return response()->json(['message' => 'Seul le responsable de la course peut valider une équipe.'], 403);
        }
        
        $race = Race::findOrFail($request->race_id);
        $isCompetitive = stripos($race->RAC_TYPE, 'Compétition') !== false || stripos($race->RAC_TYPE, 'Competitif') !== false; // Adjust check based on exact string

        // Get all members
        $members = DB::table('SAN_USERS_TEAMS')
            ->join('SAN_USERS', 'SAN_USERS_TEAMS.USE_ID', '=', 'SAN_USERS.USE_ID')
            ->join('SAN_USERS_RACES', function($join) use ($request) {
                $join->on('SAN_USERS.USE_ID', '=', 'SAN_USERS_RACES.USE_ID')
                    ->where('SAN_USERS_RACES.RAC_ID', '=', $request->race_id);
            })
            ->where('SAN_USERS_TEAMS.TEA_ID', $request->team_id)
            ->select('SAN_USERS.*', 'SAN_USERS_RACES.USR_CHIP_NUMBER', 'SAN_USERS_RACES.USR_PPS_FORM')
            ->get();

        foreach ($members as $member) {
            // Check License or PPS
            $hasLicense = !empty($member->USE_LICENCE_NUMBER);
            $hasPPS = !empty($member->USR_PPS_FORM);
            
            // "Si la personne a une licence number alors pas besoin de mettre un pps sinon obligatoire"
            if (!$hasLicense && !$hasPPS) {
                return response()->json(['message' => "Le membre {$member->USE_NAME} {$member->USE_LAST_NAME} doit avoir une licence ou un PPS validé."], 422);
            }

            // Check Chip if competitive
            if ($isCompetitive && empty($member->USR_CHIP_NUMBER)) {
                return response()->json(['message' => "Member {$member->USE_NAME} {$member->USE_LAST_NAME} needs a chip number for competitive race"], 422);
            }
        }

        DB::table('SAN_TEAMS_RACES')
            ->where('TEA_ID', $request->team_id)
            ->where('RAC_ID', $request->race_id)
            ->update(['TER_IS_VALID' => 1]);

        return response()->json(['message' => 'Team validated successfully']);
    }

    /**
     * Unvalidate the team for the race (if race hasn't started)
     */
    public function unvalidateTeamForRace(Request $request)
    {
        $request->validate([
            'team_id' => 'required|integer',
            'race_id' => 'required|integer',
        ]);

        $team = Team::findOrFail($request->team_id);
        $race = Race::findOrFail($request->race_id);

        // Allow Race Manager
        if ($race->USE_ID !== auth()->id()) {
             return response()->json(['message' => 'Seul le responsable de la course peut dévalider une équipe.'], 403);
        }

        // Check if race has started
        $raceStart = \Carbon\Carbon::parse($race->RAC_TIME_START);
        if (now()->greaterThanOrEqualTo($raceStart)) {
            return response()->json(['message' => 'Impossible de dévalider l\'équipe après le début de la course'], 422);
        }

        DB::table('SAN_TEAMS_RACES')
            ->where('TEA_ID', $request->team_id)
            ->where('RAC_ID', $request->race_id)
            ->update(['TER_IS_VALID' => 0]);

        return response()->json(['message' => 'Team unvalidated successfully']);
    }


    public function getTeamById($id)
    {
        $team = Team::find($id);
        if (!$team) {
            return response()->json([
                'message' => 'Team not found',
            ], 404);
        }
        return response()->json(['data' => $team], 200);
    }


    public function getTeamsByRace($raceId)
    {
        $teams = Team::whereHas('races', function ($q) use ($raceId) {
            $q->where('SAN_TEAMS_RACES.RAC_ID', $raceId);
        })->get();

        return response()->json(['data' => $teams], 200);
    }

}
