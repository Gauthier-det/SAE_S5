<?php

namespace App\Http\Controllers;

use App\Models\Race;
use App\Models\Raid;
use App\Models\User;
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
        if (!$race) {
            return response()->json([
                'message' => 'Race not found',
            ], 404);
        }
        return response()->json(['data' => $race], 200);
    }

    public function getRaceByIdWithPrice($id)
    {
        $race = Race::with('categories')
            ->find($id);

        if (!$race) {
            return response()->json([
                'message' => 'Race not found',
            ], 404);
        }

        // Map prices from categories relationship
        $priceMap = [
            1 => 'CAT_1_PRICE',
            2 => 'CAT_2_PRICE',
            3 => 'CAT_3_PRICE',
        ];

        foreach ($race->categories as $category) {
            $catId = $category->CAT_ID;
            if (isset($priceMap[$catId])) {
                $race[$priceMap[$catId]] = $category->pivot->CAR_PRICE ?? 0;
            }
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


    public function storeTeamRaceResult(Request $request, $raceId)
    {
        $race = Race::find($raceId);
        if (!$race) {
            return response()->json([
                'message' => 'Race not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'TEA_ID' => 'required|integer|exists:SAN_TEAMS,TEA_ID',
            'TER_TIME' => 'nullable|date_format:H:i:s',
            'TER_IS_VALID' => 'nullable|integer|in:0,1',
            'TER_RACE_NUMBER' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::table('SAN_TEAMS_RACES')->insert([
                'RAC_ID' => $raceId,
                'TEA_ID' => $request->input('TEA_ID'),
                'TER_TIME' => $request->input('TER_TIME'),
                'TER_IS_VALID' => $request->input('TER_IS_VALID'),
                'TER_RACE_NUMBER' => $request->input('TER_RACE_NUMBER'),
            ]);

            return response()->json(['message' => 'Team race result created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating team race result', 'error' => $e->getMessage()], 500);
        }
    }

    public function createRace(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'USE_ID' => 'required|integer|exists:SAN_USERS,USE_ID',
            'RAI_ID' => 'required|integer|exists:SAN_RAIDS,RAI_ID',
            'RAC_NAME' => 'required|string|max:255',
            'RAC_TIME_START' => 'required|date',
            'RAC_TIME_END' => 'required|date|after_or_equal:RAC_TIME_START',
            'RAC_GENDER' => 'required|string|in:Homme,Femme,Mixte',
            'RAC_TYPE' => 'required|string|max:255',
            'RAC_DIFFICULTY' => 'required|string|max:255',
            'RAC_MIN_PARTICIPANTS' => 'required|integer|min:0',
            'RAC_MAX_PARTICIPANTS' => 'required|integer|min:0|gte:RAC_MIN_PARTICIPANTS',
            'RAC_MIN_TEAMS' => 'required|integer|min:0',
            'RAC_MAX_TEAMS' => 'required|integer|min:0|gte:RAC_MIN_TEAMS',
            'RAC_MIN_TEAM_MEMBERS' => 'required|integer|min:0|lte:RAC_MAX_TEAM_MEMBERS',
            'RAC_MAX_TEAM_MEMBERS' => 'required|integer|min:0|gte:RAC_MIN_TEAM_MEMBERS',
            'RAC_AGE_MIN' => 'required|integer|min:0|lte:RAC_AGE_MIDDLE',
            'RAC_AGE_MIDDLE' => 'required|integer|min:0|gte:RAC_AGE_MIN|lte:RAC_AGE_MAX',
            'RAC_AGE_MAX' => 'required|integer|min:0|gte:RAC_AGE_MIDDLE',
            'RAC_CHIP_MANDATORY' => 'required|integer|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $raid = Raid::find($request->RAI_ID);
        if (auth()->user()->USE_ID !== $raid->USE_ID && !auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized. Only the raid manager can create races for this raid.',
            ], 403);
        }

        $raceManager = User::find($request->USE_ID);
        if ($raceManager->CLU_ID !== $raid->CLU_ID) {
            return response()->json([
                'message' => 'Unauthorized. The race manager must be a member of the club hosting the raid.',
            ], 403);
        }
        if ($raceManager->USE_LICENCE_NUMBER === null) {
            return response()->json([
                'message' => 'Unauthorized. The race manager must have a valid licence number.',
            ], 403);
        }

        $race = Race::create($request->only([
            'USE_ID',
            'RAI_ID',
            'RAC_NAME',
            'RAC_TIME_START',
            'RAC_TIME_END',
            'RAC_GENDER',
            'RAC_TYPE',
            'RAC_DIFFICULTY',
            'RAC_MIN_PARTICIPANTS',
            'RAC_MAX_PARTICIPANTS',
            'RAC_MIN_TEAMS',
            'RAC_MAX_TEAMS',
            'RAC_MIN_TEAM_MEMBERS',
            'RAC_MAX_TEAM_MEMBERS',
            'RAC_AGE_MIN',
            'RAC_AGE_MIDDLE',
            'RAC_AGE_MAX',
            'RAC_CHIP_MANDATORY',
        ]));

        return response()->json(['data' => $race], 201);
    }

    public function createRaceWithPrices(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'USE_ID' => 'required|integer|exists:SAN_USERS,USE_ID',
            'RAI_ID' => 'required|integer|exists:SAN_RAIDS,RAI_ID',
            'RAC_NAME' => 'required|string|max:255',
            'RAC_TIME_START' => 'required|date',
            'RAC_TIME_END' => 'required|date|after_or_equal:RAC_TIME_START',
            'RAC_GENDER' => 'required|string|in:Homme,Femme,Mixte',
            'RAC_TYPE' => 'required|string|max:255',
            'RAC_DIFFICULTY' => 'required|string|max:255',
            'RAC_MIN_PARTICIPANTS' => 'required|integer|min:0',
            'RAC_MAX_PARTICIPANTS' => 'required|integer|min:0|gte:RAC_MIN_PARTICIPANTS',
            'RAC_MIN_TEAMS' => 'required|integer|min:0',
            'RAC_MAX_TEAMS' => 'required|integer|min:0|gte:RAC_MIN_TEAMS',
            'RAC_MIN_TEAM_MEMBERS' => 'required|integer|min:0|lte:RAC_MAX_TEAM_MEMBERS',
            'RAC_MAX_TEAM_MEMBERS' => 'required|integer|min:0|gte:RAC_MIN_TEAM_MEMBERS',
            'RAC_AGE_MIN' => 'required|integer|min:0|lte:RAC_AGE_MIDDLE',
            'RAC_AGE_MIDDLE' => 'required|integer|min:0|gte:RAC_AGE_MIN|lte:RAC_AGE_MAX',
            'RAC_AGE_MAX' => 'required|integer|min:0|gte:RAC_AGE_MIDDLE',
            'RAC_CHIP_MANDATORY' => 'required|integer|in:0,1',
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
                'RAC_NAME',
                'RAC_TIME_START',
                'RAC_TIME_END',
                'RAC_GENDER',
                'RAC_TYPE',
                'RAC_DIFFICULTY',
                'RAC_MIN_PARTICIPANTS',
                'RAC_MAX_PARTICIPANTS',
                'RAC_MIN_TEAMS',
                'RAC_MAX_TEAMS',
                'RAC_MIN_TEAM_MEMBERS',
                'RAC_MAX_TEAM_MEMBERS',
                'RAC_AGE_MIN',
                'RAC_AGE_MIDDLE',
                'RAC_AGE_MAX',
                'RAC_CHIP_MANDATORY',
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
        $race = Race::with('raid')->find($id);
        if (!$race) {
            return response()->json(['message' => 'Race not found'], 404);
        }

        if (auth()->user()->USE_ID !== $race->raid->USE_ID && !auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized. Only the raid Manager can update races.',
            ], 403);
        }

        $dataForValidation = array_merge($race->toArray(), $request->all());

        $validator = Validator::make($dataForValidation, [
            'USE_ID' => 'sometimes|integer|exists:SAN_USERS,USE_ID',
            'RAI_ID' => 'sometimes|integer|exists:SAN_RAIDS,RAI_ID',
            'RAC_NAME' => 'sometimes|string|max:255',
            'RAC_TIME_START' => 'sometimes|date_format:Y-m-d H:i:s',
            'RAC_TIME_END' => 'sometimes|date_format:Y-m-d H:i:s|after_or_equal:RAC_TIME_START',
            'RAC_GENDER' => 'sometimes|string|in:Homme,Femme,Mixte',
            'RAC_TYPE' => 'sometimes|string|max:255',
            'RAC_DIFFICULTY' => 'sometimes|string|max:255',
            'RAC_MIN_PARTICIPANTS' => 'sometimes|integer|min:0',
            'RAC_MAX_PARTICIPANTS' => 'sometimes|integer|min:0|gte:RAC_MIN_PARTICIPANTS',
            'RAC_MIN_TEAMS' => 'sometimes|integer|min:0',
            'RAC_MAX_TEAMS' => 'sometimes|integer|min:0|gte:RAC_MIN_TEAMS',
            'RAC_MIN_TEAM_MEMBERS' => 'sometimes|integer|min:0|lte:RAC_MAX_TEAM_MEMBERS',
            'RAC_MAX_TEAM_MEMBERS' => 'sometimes|integer|min:0|gte:RAC_MIN_TEAM_MEMBERS',
            'RAC_AGE_MIN' => 'sometimes|integer|min:0|lte:RAC_AGE_MIDDLE',
            'RAC_AGE_MIDDLE' => 'sometimes|integer|min:0|gte:RAC_AGE_MIN|lte:RAC_AGE_MAX',
            'RAC_AGE_MAX' => 'sometimes|integer|min:0|gte:RAC_AGE_MIDDLE',
            'RAC_CHIP_MANDATORY' => 'sometimes|integer|in:0,1',
            'CAT_1_PRICE' => 'sometimes|numeric|min:0',
            'CAT_2_PRICE' => 'sometimes|numeric|min:0',
            'CAT_3_PRICE' => 'sometimes|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->has('USE_ID')) {
            $raid = Raid::find($race->RAI_ID);
            $raceManager = User::find($request->USE_ID);
            if ($raceManager->CLU_ID !== $raid->CLU_ID) {
                return response()->json([
                    'message' => 'Unauthorized. The race manager must be a member of the club hosting the raid.',
                ], 403);
            }
            if ($raceManager->USE_LICENCE_NUMBER === null) {
                return response()->json([
                    'message' => 'Unauthorized. The race manager must have a valid licence number.',
                ], 403);
            }
        }

        try {
            DB::beginTransaction();

            $race->update($request->only([
                'USE_ID',
                'RAI_ID',
                'RAC_NAME',
                'RAC_TIME_START',
                'RAC_TIME_END',
                'RAC_GENDER',
                'RAC_TYPE',
                'RAC_DIFFICULTY',
                'RAC_MIN_PARTICIPANTS',
                'RAC_MAX_PARTICIPANTS',
                'RAC_MIN_TEAMS',
                'RAC_MAX_TEAMS',
                'RAC_MIN_TEAM_MEMBERS',
                'RAC_MAX_TEAM_MEMBERS',
                'RAC_AGE_MIN',
                'RAC_AGE_MIDDLE',
                'RAC_AGE_MAX',
                'RAC_CHIP_MANDATORY',
            ]));

            // Update prices if provided
            if ($request->has('CAT_1_PRICE') || $request->has('CAT_2_PRICE') || $request->has('CAT_3_PRICE')) {
                for ($catId = 1; $catId <= 3; $catId++) {
                    if ($request->has('CAT_' . $catId . '_PRICE')) {
                        DB::table('SAN_CATEGORIES_RACES')
                            ->where('RAC_ID', $race->RAC_ID)
                            ->where('CAT_ID', $catId)
                            ->update([
                                'CAR_PRICE' => $request->input('CAT_' . $catId . '_PRICE'),
                            ]);
                    }
                }
            }

            DB::commit();

            $race->load('categories');

            return response()->json(['data' => $race], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Race update error: ' . $e->getMessage() . ' - ' . $e->getFile() . ':' . $e->getLine());
            return response()->json([
                'message' => 'Error updating race',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    public function deleteRace($id)
    {
        $race = Race::with('raid')->find($id);
        if (!$race) {
            return response()->json(['message' => 'Race not found'], 404);
        }

        if (auth()->user()->USE_ID !== $race->raid->USE_ID && !auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized. Only the raid Manager can update races.',
            ], 403);
        }

        $race->delete();
        return response()->json(['message' => 'Race deleted successfully'], 200);
    }

    public function getRaceDetails($id)
    {
        $race = Race::with([
            'user',
            'raid',
            'categories' => function ($query) {
                $query->withPivot('CAR_PRICE');
            },
            'teams.owner',
            'teams.members',
            'user',
            'raid'
        ])->find($id);

        if (!$race) {
            return response()->json(['message' => 'Race not found'], 404);
        }

        // Calculate stats based on participants
        $participantsCount = 0;
        foreach ($race->teams as $team) {
            $participantsCount += $team->members->count();
        }

        $maxParticipants = $race->RAC_MAX_PARTICIPANTS;
        $placesRemaining = max(0, $maxParticipants - $participantsCount);
        $fillingRate = $maxParticipants > 0 ? round(($participantsCount / $maxParticipants) * 100) : 0;

        $raceData = $race->toArray();
        $raceData['stats'] = [
            'teams_count' => $race->teams->count(),
            'participants_count' => $participantsCount,
            'places_remaining' => $placesRemaining, // Now based on participants
            'filling_rate' => $fillingRate, // Now based on participants
            'participants_expected_min' => $race->RAC_MIN_PARTICIPANTS,
            'participants_expected_max' => $race->RAC_MAX_PARTICIPANTS,
        ];

        // Check if there are any results
        $hasResults = false;
        foreach ($race->teams as $team) {
            if ($team->pivot->TER_RANK !== null || $team->pivot->TER_TIME !== null) {
                $hasResults = true;
                break;
            }
        }
        $raceData['has_results'] = $hasResults;

        // Format categories
        $raceData['formatted_categories'] = $race->categories->map(function ($cat) {
            return [
                'id' => $cat->CAT_ID,
                'label' => $cat->CAT_LABEL,
                'price' => $cat->pivot->CAR_PRICE,
            ];
        });

        // Format teams list
        $raceData['teams_list'] = $race->teams->map(function ($team) {
            return [
                'id' => $team->TEA_ID,
                'name' => $team->TEA_NAME,
                'image' => $team->TEA_IMAGE,
                'members_count' => $team->members->count(),
                'responsible' => $team->owner ? [
                    'id' => $team->owner->USE_ID,
                    'name' => $team->owner->USE_NAME . ' ' . $team->owner->USE_LAST_NAME,
                ] : null,
                'members' => $team->members->map(function ($member) {
                    return [
                        'id' => $member->USE_ID,
                        'name' => $member->USE_NAME . ' ' . $member->USE_LAST_NAME,
                        'email' => $member->USE_MAIL,
                    ];
                }),
                'result' => [
                    'rank' => $team->pivot->TER_RANK,
                    'time' => $team->pivot->TER_TIME,
                    'bonus' => $team->pivot->TER_BONUS_POINTS,
                ],
                'is_valid' => (bool) $team->pivot->TER_IS_VALID,
            ];
        });

        // Remove raw relationships to clean up response size if needed, 
        // but 'toArray()' already included them. We can overwrite 'teams' or just keep 'teams_list'.
        unset($raceData['teams']);

        return response()->json(['data' => $raceData], 200);
    }

    public function deleteResults($raceId)
    {
        $race = Race::find($raceId);
        if (!$race) {
            return response()->json(['message' => 'Race not found'], 404);
        }

        if (auth()->user()->USE_ID !== $race->USE_ID && !auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized. Only the race manager can delete results.',
            ], 403);
        }

        // Set rank, time, bonus to null for this race
        DB::table('SAN_TEAMS_RACES')
            ->where('RAC_ID', $raceId)
            ->update([
                'TER_RANK' => null,
                'TER_TIME' => null,
                'TER_BONUS_POINTS' => null,
            ]);

        return response()->json(['message' => 'Results deleted successfully'], 200);
    }

    public function importResults(Request $request, $raceId)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $race = Race::find($raceId);
        if (!$race) {
            return response()->json(['message' => 'Race not found'], 404);
        }

        if (auth()->user()->USE_ID !== $race->USE_ID && !auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized. Only the race manager can import results.',
            ], 403);
        }

        try {
            DB::beginTransaction();

            $file = $request->file('file');
            $path = $file->getPathname();

            // Detect separator
            $firstLine = fgets(fopen($path, 'r'));
            $separator = (strpos($firstLine, ';') !== false) ? ';' : ',';

            $handle = fopen($path, 'r');

            // Handle UTF-8 BOM
            $bom = fread($handle, 3);
            if ($bom != "\xEF\xBB\xBF") {
                rewind($handle);
            }

            $header = fgetcsv($handle, 0, $separator);

            if (!$header) {
                fclose($handle);
                return response()->json(['message' => 'Fichier CSV vide ou invalide'], 422);
            }

            // Normalize header
            $header = array_map(function ($h) {
                return mb_strtolower(trim($h), 'UTF-8');
            }, $header);

            // Find column indices
            $rankIndex = false;
            $teamNameIndex = false;
            $bonusIndex = false;
            $timeIndex = false;

            foreach ($header as $index => $col) {
                if ($col === 'clt' || $col === 'classement')
                    $rankIndex = $index;
                if (strpos($col, 'quipe') !== false)
                    $teamNameIndex = $index;
                if (strpos($col, 'pts bonus') !== false || strpos($col, 'points bonus') !== false)
                    $bonusIndex = $index;
                if ($col === 'temps' || $col === 'temp' || $col === 'chrono')
                    $timeIndex = $index;
            }

            if ($teamNameIndex === false) {
                fclose($handle);
                return response()->json(['message' => 'Colonne "équipe" introuvable dans le CSV'], 422);
            }

            $rowsToProcess = [];
            $missingTeams = [];
            $notRegisteredTeams = [];

            while (($row = fgetcsv($handle, 0, $separator)) !== false) {
                if (count($row) < count($header))
                    continue;

                $teamName = isset($row[$teamNameIndex]) ? trim($row[$teamNameIndex]) : '';
                if (empty($teamName))
                    continue;

                // Check if team exists in DB
                $team = DB::table('SAN_TEAMS')->where('TEA_NAME', $teamName)->first();

                if (!$team) {
                    if (!in_array($teamName, $missingTeams)) {
                        $missingTeams[] = $teamName;
                    }
                    continue; // Skip further checks for this row
                }

                // Check if team is registered for this race
                $isRegistered = DB::table('SAN_TEAMS_RACES')
                    ->where('RAC_ID', $raceId)
                    ->where('TEA_ID', $team->TEA_ID)
                    ->exists();

                if (!$isRegistered) {
                    if (!in_array($teamName, $notRegisteredTeams)) {
                        $notRegisteredTeams[] = $teamName;
                    }
                    continue;
                }

                // Prepare data for update if valid
                $rowsToProcess[] = [
                    'team_id' => $team->TEA_ID,
                    'row' => $row
                ];
            }

            fclose($handle);

            // If there are errors, rollback (implicit since we haven't written yet) and return error
            if (!empty($missingTeams)) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Le fichier comprend un club inexistant : ' . implode(', ', $missingTeams)
                ], 422);
            }

            if (!empty($notRegisteredTeams)) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Les équipes suivantes ne sont pas inscrites à cette course : ' . implode(', ', $notRegisteredTeams)
                ], 422);
            }

            // Process updates
            $results = [];
            foreach ($rowsToProcess as $item) {
                $teamId = $item['team_id'];
                $row = $item['row'];
                $updateData = [];

                if ($rankIndex !== false && isset($row[$rankIndex])) {
                    $val = trim($row[$rankIndex]);
                    if ($val !== '')
                        $updateData['TER_RANK'] = intval($val);
                }
                if ($bonusIndex !== false && isset($row[$bonusIndex])) {
                    $val = trim($row[$bonusIndex]);
                    if ($val !== '')
                        $updateData['TER_BONUS_POINTS'] = intval($val);
                }
                if ($timeIndex !== false && isset($row[$timeIndex])) {
                    $timeStr = trim($row[$timeIndex]);
                    if (!empty($timeStr)) {
                        $updateData['TER_TIME'] = $timeStr;
                    }
                }

                if (!empty($updateData)) {
                    DB::table('SAN_TEAMS_RACES')
                        ->where('RAC_ID', $raceId)
                        ->where('TEA_ID', $teamId)
                        ->update($updateData);

                    $results[] = ['status' => 'Updated'];
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Résultats importés avec succès',
                'details' => $results // Optional, frontend doesn't use it much yet
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($handle) && is_resource($handle)) {
                fclose($handle);
            }
            return response()->json(['message' => 'Erreur lors de l\'import', 'error' => $e->getMessage()], 500);
        }
    }
}
