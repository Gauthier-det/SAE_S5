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

        $user = User::where('USE_MAIL', $request->mail)->first();

        if (!$user || !Hash::check($request->password, $user->USE_PASSWORD)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user_id' => $user->USE_ID,
            'user_name' => $user->USE_NAME,
            'user_last_name' => $user->USE_LAST_NAME,
            'user_mail' => $user->USE_MAIL,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'mail' => 'required|email|unique:SAN_USERS,USE_MAIL',
                'password' => 'required|min:6',
                'name' => 'required|string',
                'last_name' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        $user = User::create([
            'USE_MAIL' => $request->mail,
            'USE_PASSWORD' => Hash::make($request->password),
            'USE_NAME' => $request->name,
            'USE_LAST_NAME' => $request->last_name,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user_id' => $user->USE_ID,
            'user_name' => $user->USE_NAME,
            'user_last_name' => $user->USE_LAST_NAME,
            'user_mail' => $user->USE_MAIL,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
