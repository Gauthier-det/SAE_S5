<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClubController extends Controller
{
    public function getAllClubs()
    {
        $clubs = Club::all();
        return response()->json(['data' => $clubs]);
    }

    public function getClubById($id)
    {
        $club = Club::find($id);
        if (! $club) {
            return response()->json([
                'message' => 'Club not found',
            ], 404);
        }
        return response()->json(['data' => $club], 200);
    }
}