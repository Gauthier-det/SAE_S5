<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Race;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
        $request->validate([
            'user_id' => 'required|integer|exists:SAN_USERS,USE_ID',
            'team_id' => 'required|integer|exists:SAN_TEAMS,TEA_ID',
            'race_id' => 'required|integer|exists:SAN_RACES,RAC_ID',
        ]);

        // Check if user can access this team (owner check)
        $team = Team::findOrFail($request->team_id);
        if ($team->USE_ID !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized - you did not create this team'], 403);
        }

        // Prevent duplicate membership
        $exists = DB::table('SAN_USERS_TEAMS')
            ->where('USE_ID', $request->user_id)
            ->where('TEA_ID', $request->team_id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'User is already part of the team'], 409);
        }

        // Check for race time conflicts
        $race = Race::findOrFail($request->race_id);
        $conflictingRace = DB::table('SAN_USERS_RACES')
            ->join('SAN_RACES', 'SAN_USERS_RACES.RAC_ID', '=', 'SAN_RACES.RAC_ID')
            ->where('SAN_USERS_RACES.USE_ID', $request->user_id)
            ->where(function ($query) use ($race) {
                $query->where(function ($q) use ($race) {
                    $q->where('SAN_RACES.RAC_TIME_START', '<', $race->RAC_TIME_END)
                      ->where('SAN_RACES.RAC_TIME_END', '>', $race->RAC_TIME_START);
                });
            })
            ->exists();

        if ($conflictingRace) {
            return response()->json(['message' => 'User already registered for a race with overlapping time'], 409);
        }

        // Add user to team
        DB::table('SAN_USERS_TEAMS')->insert([
            'USE_ID' => $request->user_id,
            'TEA_ID' => $request->team_id,
        ]);

        // Add user to race with empty chip and time
        DB::table('SAN_USERS_RACES')->insert([
            'USE_ID' => $request->user_id,
            'RAC_ID' => $request->race_id,
            'USR_CHIP_NUMBER' => null,
            'USR_TIME' => null,
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
}
