<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ClubController extends Controller
{
    public function getAllClubs()
    {
        $clubs = Club::with(['address', 'user'])->withCount('users')->get();
        return response()->json(['data' => $clubs]);
    }

    public function getClubById($id)
    {
        $club = Club::find($id);
        if (!$club) {
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
            'ADD_STREET_NAME' => 'nullable|string|max:255',
            'ADD_STREET_NUMBER' => 'nullable|string|max:8',
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

            // Link manager to the new club
            $manager = User::find($request->input('USE_ID'));
            if ($manager) {
                $manager->CLU_ID = $club->CLU_ID;
                $manager->save();
            }

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
        if (!$club) {
            return response()->json([
                'message' => 'Club not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'CLU_NAME' => 'sometimes|required|string|max:255',
            'USE_ID' => 'sometimes|required|integer|exists:SAN_USERS,USE_ID',
            'ADD_POSTAL_CODE' => 'nullable|integer|digits:5',
            'ADD_CITY' => 'nullable|string|max:255',
            'ADD_STREET_NAME' => 'nullable|string|max:255',
            'ADD_STREET_NUMBER' => 'nullable|string|max:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update basic club info
        $club->update($request->only(['CLU_NAME', 'USE_ID']));

        // Handle Address Update
        if ($club->ADD_ID) {
            $address = Address::find($club->ADD_ID);
            if ($address) {
                // Only update fields managed by the form
                $addressData = $request->only([
                    'ADD_POSTAL_CODE',
                    'ADD_CITY',
                    'ADD_STREET_NAME',
                    'ADD_STREET_NUMBER'
                ]);
                // Filter out nulls if we want partial updates, but here form sends empty strings usually.
                // Assuming form sends current state.
                $address->update($addressData);
            }
        }

        // Handle User Manager Association
        if ($request->has('USE_ID') && $request->input('USE_ID') !== $club->getOriginal('USE_ID')) {
            $newManagerId = $request->input('USE_ID');
            $newManager = User::find($newManagerId);
            if ($newManager) {
                $newManager->CLU_ID = $club->CLU_ID;
                $newManager->save();
            }
        } elseif ($request->has('USE_ID')) {
            // Even if manager didn't change ID, ensure association is correct (idempotent)
            $managerId = $request->input('USE_ID');
            $manager = User::find($managerId);
            if ($manager && $manager->CLU_ID !== $club->CLU_ID) {
                $manager->CLU_ID = $club->CLU_ID;
                $manager->save();
            }
        }

        return response()->json(['data' => $club], 200);
    }

    public function deleteClub($id)
    {
        $club = Club::find($id);
        if (!$club) {
            return response()->json([
                'message' => 'Club not found',
            ], 404);
        }

        $club->delete();
        return response()->json(['message' => 'Club deleted successfully'], 200);
    }
}