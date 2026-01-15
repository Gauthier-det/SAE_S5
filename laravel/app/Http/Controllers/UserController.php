<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getAllUsers()
    {
        $users = User::all();
        return response()->json(['data' => $users]);
    }

    public function getUserInfo(Request $request)
    {
        return $request->user()->load('address')->load('club')->load('races');
    }

    public function getUserById($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
        return response()->json(['data' => $user], 200);
    }

    public function getUsersByClub($clubId)
    {
        $users = User::where('CLU_ID', $clubId)->get();
        return response()->json(['data' => $users], 200);
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'USE_MAIL' => 'required|email|unique:SAN_USERS,USE_MAIL',
            'USE_PASSWORD' => 'required|string|min:8',
            'USE_NAME' => 'required|string|max:255',
            'USE_LAST_NAME' => 'required|string|max:255',
            'USE_GENDER' => 'required|string|in:Homme,Femme,Autre',
            'USE_BIRTHDATE' => 'nullable|date',
            'USE_PHONE_NUMBER' => 'nullable|string|max:20',
            'USE_LICENCE_NUMBER' => 'nullable|integer',
            'USE_MEMBERSHIP_DATE' => 'required|date',
            'USE_VALIDITY' => 'nullable|date',
            'CLU_ID' => 'nullable|exists:SAN_CLUBS,CLU_ID',
            'ADD_ID' => 'nullable|exists:SAN_ADDRESSES,ADD_ID',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->all();
        // $data['USE_PASSWORD'] = Hash::make($data['USE_PASSWORD']); // Removed double hashing

        $user = User::create($data);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        if (auth()->user()->USE_ID !== (int) $id && !auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized. You can only update your own profile.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'USE_MAIL' => 'sometimes|email|unique:SAN_USERS,USE_MAIL,' . $id . ',USE_ID',
            'USE_PASSWORD' => 'sometimes|string|min:8',
            'USE_NAME' => 'sometimes|string|max:255',
            'USE_LAST_NAME' => 'sometimes|string|max:255',
            'USE_GENDER' => 'sometimes|string|in:Homme,Femme,Autre',
            'USE_BIRTHDATE' => 'sometimes|nullable|date',
            'USE_PHONE_NUMBER' => 'sometimes|nullable|string|max:20',
            'USE_LICENCE_NUMBER' => 'sometimes|nullable|integer',
            'USE_MEMBERSHIP_DATE' => 'sometimes|nullable|date',
            'USE_VALIDITY' => 'sometimes|nullable|date',
            'CLU_ID' => 'sometimes|nullable|exists:SAN_CLUBS,CLU_ID',
            'ADD_ID' => 'sometimes|nullable|exists:SAN_ADDRESSES,ADD_ID',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->all();

        if (isset($data['USE_PASSWORD'])) {
            // $data['USE_PASSWORD'] = Hash::make($data['USE_PASSWORD']); // Removed double hashing
        }

        $user->update($data);

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user,
        ], 200);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        if (auth()->user()->USE_ID !== (int) $id && !auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized. You can only delete your own profile.',
            ], 403);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully',
        ], 200);
    }

    public function checkIsAdmin(Request $request)
    {
        return response()->json(['is_admin' => $request->user()->isAdmin()]);
    }

    public function getUserStats($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        // Retrieve user race results with times
        $races = \DB::table('SAN_USERS_RACES')
            ->where('USE_ID', $id)
            ->whereNotNull('USR_TIME')
            ->get();

        $racesRun = $races->count();

        // Count podiums (top 3 in each race)
        $podiums = 0;
        foreach ($races as $race) {
            // Get the ranking for this race
            $rank = \DB::table('SAN_USERS_RACES')
                ->where('RAC_ID', $race->RAC_ID)
                ->whereNotNull('USR_TIME')
                ->orderBy('USR_TIME', 'asc')
                ->pluck('USE_ID')
                ->search($id);

            if ($rank !== false && $rank < 3) {
                $podiums++;
            }
        }

        // Calculate points (1st=10, 2nd=8, 3rd=6, 4th=4, 5th=2, 6th+=1)
        $pointsSystem = [10, 8, 6, 4, 2, 1];
        $totalPoints = 0;

        foreach ($races as $race) {
            $rank = \DB::table('SAN_USERS_RACES')
                ->where('RAC_ID', $race->RAC_ID)
                ->whereNotNull('USR_TIME')
                ->orderBy('USR_TIME', 'asc')
                ->pluck('USE_ID')
                ->search($id);

            if ($rank !== false) {
                $points = $pointsSystem[min($rank, 5)] ?? 1;
                $totalPoints += $points;
            }
        }

        return response()->json([
            'racesRun' => $racesRun,
            'podiums' => $podiums,
            'totalPoints' => $totalPoints,
        ], 200);
    }

    public function getUserHistory($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        // Retrieve race history with rankings
        $raceResults = \DB::table('SAN_USERS_RACES')
            ->join('SAN_RACES', 'SAN_USERS_RACES.RAC_ID', '=', 'SAN_RACES.RAC_ID')
            ->join('SAN_RAIDS', 'SAN_RACES.RAI_ID', '=', 'SAN_RAIDS.RAI_ID')
            ->where('SAN_USERS_RACES.USE_ID', $id)
            ->whereNotNull('SAN_USERS_RACES.USR_TIME')
            ->select(
                'SAN_RAIDS.RAI_NAME as raid',
                'SAN_RACES.RAC_TYPE as race',
                'SAN_RACES.RAC_TIME_START as date',
                'SAN_RACES.RAC_ID'
            )
            ->orderBy('SAN_RACES.RAC_TIME_START', 'desc')
            ->get();

        $pointsSystem = [10, 8, 6, 4, 2, 1];
        $history = [];

        foreach ($raceResults as $result) {
            // Calculate ranking
            $rank = \DB::table('SAN_USERS_RACES')
                ->where('RAC_ID', $result->RAC_ID)
                ->whereNotNull('USR_TIME')
                ->orderBy('USR_TIME', 'asc')
                ->pluck('USE_ID')
                ->search($id);

            // Calculate points
            $points = 0;
            if ($rank !== false) {
                $points = $pointsSystem[min($rank, 5)] ?? 1;
            }

            $history[] = [
                'date' => \Carbon\Carbon::parse($result->date)->format('d/m/Y'),
                'raid' => $result->raid,
                'race' => $result->race,
                'rank' => $this->getRankOrdinal($rank + 1),
                'points' => $points,
            ];
        }

        return response()->json(['data' => $history], 200);
    }

    private function getRankOrdinal($rank)
    {
        if ($rank === 1) {
            return '1ère';
        }
        return $rank . 'e';
    }

    public function getFreeRunners()
    {
        $users = User::whereNull('CLU_ID')->get();
        return response()->json(['data' => $users], 200);
    }
    public function registerUserToRace(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'USE_ID' => 'required|integer|exists:SAN_USERS,USE_ID',
            'RAC_ID' => 'required|integer|exists:SAN_RACES,RAC_ID',
            'USR_CHIP_NUMBER' => 'nullable|string|max:255',
            'USR_TIME' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $exists = \DB::table('SAN_USERS_RACES')
            ->where('USE_ID', $request->USE_ID)
            ->where('RAC_ID', $request->RAC_ID)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'User already registered for this race',
            ], 409);
        }

        \DB::table('SAN_USERS_RACES')->insert([
            'USE_ID' => $request->USE_ID,
            'RAC_ID' => $request->RAC_ID,
            'USR_CHIP_NUMBER' => $request->USR_CHIP_NUMBER,
            'USR_TIME' => $request->USR_TIME,
        ]);

        return response()->json([
            'message' => 'User registered to race successfully',
            'data' => [
                'USE_ID' => $request->USE_ID,
                'RAC_ID' => $request->RAC_ID,
                'USR_CHIP_NUMBER' => $request->USR_CHIP_NUMBER,
                'USR_TIME' => $request->USR_TIME,
            ],
        ], 201);
    }

    public function getUsersByTeam($teamId)
    {
        $users = User::whereHas('teams', function ($query) use ($teamId) {
            $query->where('SAN_USERS_TEAMS.TEA_ID', $teamId);
        })
            ->with([
                'teams' => function ($query) use ($teamId) {
                    $query->where('SAN_USERS_TEAMS.TEA_ID', $teamId);
                },
                'address',
                'club'
            ])
            ->get();

        return response()->json(['data' => $users], 200);
    }

}
