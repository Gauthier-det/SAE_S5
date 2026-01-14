<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClubController extends Controller
{
    public function getAllClubs()
    {
        $clubs = Club::all();
        return response()->json(['data' => $clubs]);
    }

    public function getClubById($id)
    {
        $club = Club::find($id);
        if (! $club) {
            return response()->json([
                'message' => 'Club not found',
            ], 404);
        }
        return response()->json(['data' => $club], 200);
    }

    public function createClub(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'USE_ID' => 'required|integer|exists:SAN_USERS,USE_ID',
            'ADD_ID' => 'required|integer|exists:SAN_ADDRESSES,ADD_ID',
            'CLU_NAME' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $club = Club::create($request->only([
            'USE_ID',
            'ADD_ID',
            'CLU_NAME',
        ]));

        return response()->json(['data' => $club], 201);
    }

    public function updateClub(Request $request, $id)
    {
        $club = Club::find($id);
        if (! $club) {
            return response()->json([
                'message' => 'Club not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'USE_ID' => 'sometimes|integer|exists:SAN_USERS,USE_ID',
            'ADD_ID' => 'sometimes|integer|exists:SAN_ADDRESSES,ADD_ID',
            'CLU_NAME' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $club->update($request->only([
            'USE_ID',
            'ADD_ID',
            'CLU_NAME',
        ]));

        return response()->json(['data' => $club], 200);
    }

    public function deleteClub($id)
    {
        $club = Club::find($id);
        if (! $club) {
            return response()->json([
                'message' => 'Club not found',
            ], 404);
        }

        $club->delete();
        return response()->json(['message' => 'Club deleted successfully'], 200);
    }
}