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

    public function getRaceById($id)
    {
        $race = Race::find($id);
        if ($race) {
            return response()->json(['data' => $race]);
        } else {
            return response()->json(['message' => 'Race not found'], 404);
        }
    }

    public function createRace(Request $request)
    {
        $race = Race::create($request->all());
        return response()->json(['data' => $race], 201);
    }
}
