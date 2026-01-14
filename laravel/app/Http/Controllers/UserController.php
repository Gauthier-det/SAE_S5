<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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

        if (! $user) {
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
}
