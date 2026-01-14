<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        ]], 201);
    }

    public function addMember(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|integer|exists:users,USE_ID',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        try {
            $request->validate([
                'team_id' => 'required|integer|exists:teams,TEA_ID',
                'user_id' => 'required|integer|exists:users,USE_ID',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        $teamMember = TeamMember::create([
            'TEA_ID' => $request->team_id,
            'USE_ID' => $request->user_id,
        ]);

        return response()->json(['data' => [
            'team_member_id' => $teamMember->TME_ID,
            'team_id' => $teamMember->TEA_ID,
            'user_id' => $teamMember->USE_ID,
        ]], 201);
    }
}
