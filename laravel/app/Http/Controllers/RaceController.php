<?php

namespace App\Http\Controllers;

use App\Models\Race;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RaceController extends Controller
{
    public function getAllRaces()
    {
        $races = Race::with(['user', 'raid'])->get();
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
        $races = Race::where('RAI_ID', $raidId)->get()->load('user');

        return response()->json(['data' => $races], 200);
    }

    public function getRaceResults($raceId)
    {
        $race = Race::find($raceId);
        if (!$race) {
            return response()->json([
                'message' => 'Race not found',
            ], 404);
        }

        $results = $race->teams()
            ->orderBy('SAN_TEAMS_RACES.TER_TIME', 'asc')
            ->get();

        return response()->json(['data' => $results], 200);
    }

    public function getRacePrices($raceId)
    {
        $race = Race::find($raceId);
        if (!$race) {
            return response()->json([
                'message' => 'Race not found',
            ], 404);
        }

        $prices = $race->categories()
            ->select('SAN_CATEGORIES.CAT_ID', 'SAN_CATEGORIES.CAT_LABEL', 'SAN_CATEGORIES_RACES.CAR_PRICE')
            ->orderBy('SAN_CATEGORIES.CAT_ID', 'asc')
            ->get()
            ->map(function ($category) {
                return [
                    'CAT_ID' => $category->CAT_ID,
                    'CAT_LABEL' => $category->CAT_LABEL,
                    'CAR_PRICE' => $category->CAR_PRICE,
                ];
            });

        return response()->json(['data' => $prices], 200);
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

    public function createRaceWithPrices(Request $request)
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
            'CAT_1_PRICE' => 'required|numeric|min:0',
            'CAT_2_PRICE' => 'required|numeric|min:0',
            'CAT_3_PRICE' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

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

            for ($catId = 1; $catId <= 3; $catId++) {
                DB::table('SAN_CATEGORIES_RACES')->insert([
                    'RAC_ID' => $race->RAC_ID,
                    'CAT_ID' => $catId,
                    'CAR_PRICE' => $request->input('CAT_' . $catId . '_PRICE'),
                ]);
            }

            DB::commit();

            $race->load('categories');

            return response()->json(['data' => $race], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating race with prices', 'error' => $e->getMessage()], 500);
        }
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

        try {
            DB::beginTransaction();

            // Delete related records
            DB::table('SAN_TEAMS_RACES')->where('RAC_ID', $id)->delete();
            DB::table('SAN_USERS_RACES')->where('RAC_ID', $id)->delete();
            DB::table('SAN_CATEGORIES_RACES')->where('RAC_ID', $id)->delete();

            // Delete the race
            $race->delete();

            DB::commit();

            return response()->json(['message' => 'Race deleted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error deleting race', 'error' => $e->getMessage()], 500);
        }
    }
}
