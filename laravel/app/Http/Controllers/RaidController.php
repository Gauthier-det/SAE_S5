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
        $raid = Raid::with(['club', 'address'])->find($id);
        if (!$raid) {
            return response()->json([
                'message' => 'Raid not found',
            ], 404);
        }
        return response()->json(['data' => $raid], 200);
    }

    public function createRaid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'CLU_ID' => 'required|integer|exists:SAN_CLUBS,CLU_ID',
            'ADD_ID' => 'required|integer|exists:SAN_ADDRESSES,ADD_ID',
            'USE_ID' => 'required|integer|exists:SAN_USERS,USE_ID',
            'RAI_NAME' => 'required|string|max:255',
            'RAI_MAIL' => 'nullable|email|max:255|required_without:RAI_PHONE_NUMBER',
            'RAI_PHONE_NUMBER' => 'nullable|string|max:20|required_without:RAI_MAIL',
            'RAI_WEB_SITE' => 'nullable|url|max:255',
            'RAI_IMAGE' => 'nullable|string|max:255',
            'RAI_TIME_START' => 'required|date',
            'RAI_TIME_END' => 'required|date|after:RAI_TIME_START',
            'RAI_REGISTRATION_START' => 'required|date|before:RAI_TIME_START',
            'RAI_REGISTRATION_END' => 'required|date|before:RAI_TIME_START|after:RAI_REGISTRATION_START',
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

    public function updateRaid(Request $request, $id)
    {
        $raid = Raid::find($id);
        if (!$raid) {
            return response()->json(['message' => 'Raid not found'], 404);
        }

        if (auth()->user()->USE_ID !== $raid->USE_ID && !auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized. You can only update raids you created.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'CLU_ID' => 'sometimes|integer|exists:SAN_CLUBS,CLU_ID',
            'ADD_ID' => 'sometimes|integer|exists:SAN_ADDRESSES,ADD_ID',
            'RAI_NAME' => 'sometimes|string|max:255',
            'RAI_MAIL' => 'sometimes|nullable|email|max:255|required_without:RAI_PHONE_NUMBER',
            'RAI_PHONE_NUMBER' => 'sometimes|nullable|string|max:20|required_without:RAI_MAIL',
            'RAI_WEB_SITE' => 'sometimes|nullable|url|max:255',
            'RAI_IMAGE' => 'sometimes|nullable|string|max:255',
            'RAI_TIME_START' => 'sometimes|date',
            'RAI_TIME_END' => 'sometimes|date|after:RAI_TIME_START',
            'RAI_REGISTRATION_START' => 'sometimes|date|before:RAI_TIME_START',
            'RAI_REGISTRATION_END' => 'sometimes|date|before:RAI_TIME_START|after:RAI_REGISTRATION_START',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $raid->update($request->all());
        return response()->json(['data' => $raid], 200);
    }

    public function deleteRaid($id)
    {
        $raid = Raid::find($id);
        if (!$raid) {
            return response()->json(['message' => 'Raid not found'], 404);
        }

        if (auth()->user()->USE_ID !== $raid->USE_ID && !auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized. You can only delete raids you created.',
            ], 403);
        }

        $raid->delete();
        return response()->json(['message' => 'Raid deleted successfully'], 200);
    }
}
