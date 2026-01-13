<?php

namespace App\Http\Controllers;
use App\Models\Race;
use Illuminate\Http\Request;

class RaceController extends Controller
{
    public function getAllRaces()
    {
        $races = Race::all();
        return response()->json(['data' => $races]);
    }
}
