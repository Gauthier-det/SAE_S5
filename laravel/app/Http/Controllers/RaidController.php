<?php

namespace App\Http\Controllers;

use App\Models\Raid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RaidController extends Controller
{
    public function getAllRaids()
    {
        $raids = Raid::all();
        return response()->json(['data' => $raids]);
    }

    public function getRaidById($id)
    {
        $raid = Raid::find($id);
        if (! $raid) {
            return response()->json([
                'message' => 'Raid not found',
            ], 404);
        }
        return response()->json(['data' => $raid], 200);
    }

    public function createRaid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'CLU_ID'                 => 'required|integer|exists:SAN_CLUBS,CLU_ID',
            'ADD_ID'                 => 'required|integer|exists:SAN_ADDRESSES,ADD_ID',
            'USE_ID'                 => 'required|integer|exists:SAN_USERS,USE_ID',
            'RAI_NAME'               => 'required|string|max:255',
            // mail OU phone requis (au moins un)
            'RAI_MAIL'               => 'nullable|email|max:255|required_without:RAI_PHONE_NUMBER',
            'RAI_PHONE_NUMBER'       => 'nullable|string|max:20|required_without:RAI_MAIL',
            'RAI_WEB_SITE'           => 'nullable|url|max:255',
            'RAI_IMAGE'              => 'nullable|string|max:255',
            'RAI_TIME_START'         => 'required|date',
            'RAI_TIME_END'           => 'required|date|after:RAI_TIME_START',
            'RAI_REGISTRATION_START' => 'required|date|before:RAI_TIME_START',
            'RAI_REGISTRATION_END'   => 'required|date|before:RAI_TIME_START|after:RAI_REGISTRATION_START',
        ]); 

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $raid = Raid::create($request->only([
            'CLU_ID',
            'ADD_ID',
            'USE_ID',
            'RAI_NAME',
            'RAI_MAIL',
            'RAI_PHONE_NUMBER',
            'RAI_WEB_SITE',
            'RAI_IMAGE',
            'RAI_TIME_START',
            'RAI_TIME_END',
            'RAI_REGISTRATION_START',
            'RAI_REGISTRATION_END',
        ]));

        return response()->json(['data' => $raid], 201);
    }
}