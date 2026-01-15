<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'mail' => 'required|email',
                'password' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        $user = User::with(['address', 'club'])->where('USE_MAIL', $request->mail)->first();

        if (!$user || !Hash::check($request->password, $user->USE_PASSWORD)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if (!$user->isValid()) {
            return response()->json(['message' => 'User account is not valid'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => [
                'user_id' => $user->USE_ID,
                'user_name' => $user->USE_NAME,
                'user_last_name' => $user->USE_LAST_NAME,
                'user_mail' => $user->USE_MAIL,
                'user_gender' => $user->USE_GENDER,
                'user_phone' => $user->USE_PHONE_NUMBER,
                'user_birthdate' => $user->USE_BIRTHDATE ? $user->USE_BIRTHDATE->format('Y-m-d') : null,
                'user_licence' => $user->USE_LICENCE_NUMBER ? $user->USE_LICENCE_NUMBER : null,
                'user_membership_date' => $user->USE_MEMBERSHIP_DATE ? $user->USE_MEMBERSHIP_DATE->format('Y-m-d') : null,
                'user_validity' => $user->USE_VALIDITY ? $user->USE_VALIDITY->format('Y-m-d') : null,
                'user_address' => $user->address,
                'user_club' => $user->club,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]

        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete(); // Revokes ALL tokens for this user

        return response()->json(['message' => 'Logged out successfully'], 200);
    }


    public function register(Request $request)
    {
        try {
            $request->validate([
                'mail' => 'required|email|unique:SAN_USERS,USE_MAIL',
                'password' => 'required|min:8',
                'name' => 'required|string',
                'last_name' => 'required|string',
                'gender' => 'required|string|in:Homme,Femme,Autre',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        $user = User::create([
            'USE_MAIL' => $request->mail,
            'USE_PASSWORD' => $request->password,
            'USE_NAME' => $request->name,
            'USE_LAST_NAME' => $request->last_name,
            'USE_GENDER' => $request->gender
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => [
                'user_id' => $user->USE_ID,
                'user_name' => $user->USE_NAME,
                'user_last_name' => $user->USE_LAST_NAME,
                'user_mail' => $user->USE_MAIL,
                'user_gender' => $user->USE_GENDER,
                'user_phone' => $user->USE_PHONE_NUMBER,
                'user_birthdate' => null,
                'user_licence' => null,
                'user_membership_date' => null,
                'user_validity' => null,
                'user_address' => null,
                'user_club' => null,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]
        ], 201);
    }
}
