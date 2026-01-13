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
        //dd($request->method(), $request->path());
        $request->validate([
            'USE_MAIL' => 'required|email',
            'USE_PASSWORD' => 'required',
        ]);

        $user = User::where('USE_MAIL', $request->USE_MAIL)->first();

        if (!$user || $request->USE_PASSWORD !== $user->USE_PASSWORD) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
