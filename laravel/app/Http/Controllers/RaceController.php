<?php

namespace App\Http\Controllers;

use App\Models\Race;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RaceController extends Controller
{
    public function getAllRaces()
    {
        $races = Race::all();
        return response()->json(['data' => $races]);
    }

    public function getRaceById($id)
    {
        $race = Race::find($id);
        if (! $race) {
            return response()->json([
                'message' => 'Race not found',
            ], 404);
        }
        return response()->json(['data' => $race], 200);
    }

    public function getRacesByRaid($raidId)
    {
        $races = Race::where('RAI_ID', $raidId)->get();

        return response()->json(['data' => $races], 200);
    }

    public function createRace(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'USE_ID' => 'required|integer|exists:SAN_USERS,USE_ID',
            'RAI_ID' => 'required|integer|exists:SAN_RAIDS,RAI_ID',
            'RAC_TIME_START' => 'required|date',
            'RAC_TIME_END' => 'required|date|after_or_equal:RAC_TIME_START',
            'RAC_TYPE' => 'required|string|max:255',
            'RAC_DIFFICULTY' => 'required|string|max:255',
            'RAC_MIN_PARTICIPANTS' => 'required|integer|min:0',
            'RAC_MAX_PARTICIPANTS' => 'required|integer|min:0|gte:RAC_MIN_PARTICIPANTS',
            'RAC_MIN_TEAMS' => 'required|integer|min:0',
            'RAC_MAX_TEAMS' => 'required|integer|min:0|gte:RAC_MIN_TEAMS',
            'RAC_TEAM_MEMBERS' => 'required|integer|min:0',
            'RAC_AGE_MIN' => 'required|integer|min:0',
            'RAC_AGE_MIDDLE' => 'required|integer|min:0',
            'RAC_AGE_MAX' => 'required|integer|min:0|gte:RAC_AGE_MIDDLE',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $race = Race::create($request->only([
            'USE_ID',
            'RAI_ID',
            'RAC_TIME_START',
            'RAC_TIME_END',
            'RAC_TYPE',
            'RAC_DIFFICULTY',
            'RAC_MIN_PARTICIPANTS',
            'RAC_MAX_PARTICIPANTS',
            'RAC_MIN_TEAMS',
            'RAC_MAX_TEAMS',
            'RAC_TEAM_MEMBERS',
            'RAC_AGE_MIN',
            'RAC_AGE_MIDDLE',
            'RAC_AGE_MAX',
        ]));

        return response()->json(['data' => $race], 201);
    }

    public function updateRace(Request $request, $id)
    {
        $race = Race::find($id);
        if (! $race) {
            return response()->json(['message' => 'Race not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'USE_ID' => 'sometimes|integer|exists:SAN_USERS,USE_ID',
            'RAI_ID' => 'sometimes|integer|exists:SAN_RAIDS,RAI_ID',
            'RAC_TIME_START' => 'sometimes|date',
            'RAC_TIME_END' => 'sometimes|date|after_or_equal:RAC_TIME_START',
            'RAC_TYPE' => 'sometimes|string|max:255',
            'RAC_DIFFICULTY' => 'sometimes|string|max:255',
            'RAC_MIN_PARTICIPANTS' => 'sometimes|integer|min:0',
            'RAC_MAX_PARTICIPANTS' => 'sometimes|integer|min:0|gte:RAC_MIN_PARTICIPANTS',
            'RAC_MIN_TEAMS' => 'sometimes|integer|min:0',
            'RAC_MAX_TEAMS' => 'sometimes|integer|min:0|gte:RAC_MIN_TEAMS',
            'RAC_TEAM_MEMBERS' => 'sometimes|integer|min:0',
            'RAC_AGE_MIN' => 'sometimes|integer|min:0',
            'RAC_AGE_MIDDLE' => 'sometimes|integer|min:0',
            'RAC_AGE_MAX' => 'sometimes|integer|min:0|gte:RAC_AGE_MIDDLE',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $race->update($request->only([
            'USE_ID',
            'RAI_ID',
            'RAC_TIME_START',
            'RAC_TIME_END',
            'RAC_TYPE',
            'RAC_DIFFICULTY',
            'RAC_MIN_PARTICIPANTS',
            'RAC_MAX_PARTICIPANTS',
            'RAC_MIN_TEAMS',
            'RAC_MAX_TEAMS',
            'RAC_TEAM_MEMBERS',
            'RAC_AGE_MIN',
            'RAC_AGE_MIDDLE',
            'RAC_AGE_MAX',
        ]));

        return response()->json(['data' => $race], 200);
    }

    public function deleteRace($id)
    {
        $race = Race::find($id);
        if (!$race) {
            return response()->json(['message' => 'Race not found'], 404);
        }

        $race->delete();

        return response()->json(['message' => 'Race deleted successfully'], 200);
    }
}
