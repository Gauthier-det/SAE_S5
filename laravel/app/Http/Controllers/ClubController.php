<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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

    public function createClubWithAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'USE_ID' => 'required|integer|exists:SAN_USERS,USE_ID',
            'CLU_NAME' => 'required|string|max:255',
            'ADD_POSTAL_CODE' => 'required|integer|digits:5',
            'ADD_CITY' => 'required|string|max:255',
            'ADD_STREET_NAME' => 'required|string|max:255',
            'ADD_STREET_NUMBER' => 'required|string|max:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            // Create the address
            $addressId = DB::table('SAN_ADDRESSES')->insertGetId([
                'ADD_POSTAL_CODE' => $request->input('ADD_POSTAL_CODE'),
                'ADD_CITY' => $request->input('ADD_CITY'),
                'ADD_STREET_NAME' => $request->input('ADD_STREET_NAME'),
                'ADD_STREET_NUMBER' => $request->input('ADD_STREET_NUMBER'),
            ]);

            // Create the club with the address
            $club = Club::create([
                'USE_ID' => $request->input('USE_ID'),
                'ADD_ID' => $addressId,
                'CLU_NAME' => $request->input('CLU_NAME'),
            ]);

            DB::commit();

            return response()->json(['data' => $club], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating club with address', 'error' => $e->getMessage()], 500);
        }
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