<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
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

        //$userId = auth()->id() OR auth()->user()->USE_ID

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
        ]);

        // Check if user can access this team (owner check)
        $team = \App\Models\Team::findOrFail($request->team_id);
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

        DB::table('SAN_USERS_TEAMS')->insert([
            'USE_ID' => $request->user_id,
            'TEA_ID' => $request->team_id,
        ]);

        return response()->json(['data' => [
            'team_id' => $request->team_id,
            'user_id' => $request->user_id,
            'message' => 'User added to team successfully',
        ]], 201);
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
