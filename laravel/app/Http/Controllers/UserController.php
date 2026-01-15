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
            'USE_PHONE_NUMBER' => 'nullable|integer',
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
        $data['USE_PASSWORD'] = Hash::make($data['USE_PASSWORD']);

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
            'USE_PHONE_NUMBER' => 'sometimes|nullable|integer',
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
            $data['USE_PASSWORD'] = Hash::make($data['USE_PASSWORD']);
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
}
