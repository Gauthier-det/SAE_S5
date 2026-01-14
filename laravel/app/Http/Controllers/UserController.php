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
            'USE_NAME' => 'required|string|max:255',
            'USE_LAST_NAME' => 'required|string|max:255',
            'USE_PASSWORD' => 'required|string|min:8',
            'USE_PHONE_NUMBER' => 'nullable|string',
            'USE_LICENCE_NUMBER' => 'nullable|string',
            'USE_BIRTHDATE' => 'nullable|date',
            'USE_GENDER' => 'nullable|string|in:M,F,Autre',
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

        $validator = Validator::make($request->all(), [
            'USE_MAIL' => 'sometimes|email|unique:SAN_USERS,USE_MAIL,' . $id . ',USE_ID',
            'USE_NAME' => 'sometimes|string|max:255',
            'USE_LAST_NAME' => 'sometimes|string|max:255',
            'USE_PASSWORD' => 'sometimes|string|min:8',
            'USE_PHONE_NUMBER' => 'sometimes|nullable|string',
            'USE_LICENCE_NUMBER' => 'sometimes|nullable|string',
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
        
        if (isset($data['USEPASSWORD'])) {
            $data['USEPASSWORD'] = Hash::make($data['USEPASSWORD']);
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

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully',
        ], 200);
    }

}