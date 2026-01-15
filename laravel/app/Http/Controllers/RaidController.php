<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Raid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RaidController extends Controller
{
    public function getAllRaids()
    {
        $raids = Raid::with(['club', 'address', 'user'])->get();
        return response()->json(['data' => $raids]);
    }

    public function getRaidById($id)
    {
        $raid = Raid::with(['club', 'address', 'user'])->find($id);
        if (!$raid) {
            return response()->json([
                'message' => 'Raid not found',
            ], 404);
        }
        return response()->json(['data' => $raid], 200);
    }

    public function createRaid(Request $request)
    {
        
        $messages = [
            'required' => 'Le champ :attribute est obligatoire.',
            'email' => 'Le champ :attribute doit être une adresse email valide.',
            'url' => 'Le champ :attribute doit être une URL valide.',
            'date' => 'Le champ :attribute doit être une date valide.',
            'after' => 'La date :attribute doit être postérieure à :date.',
            'before' => 'La date :attribute doit être antérieure à :date.',
            'integer' => 'Le champ :attribute doit être un entier.',
            'exists' => 'Le champ :attribute sélectionné est invalide.',
            'required_without' => 'Le champ :attribute est obligatoire si :values n\'est pas renseigné.',
            'min' => 'Le champ :attribute doit être d\'au moins :min.',
        ];

        $attributes = [
            'CLU_ID' => 'Club',
            'ADD_ID' => 'Adresse',
            'USE_ID' => 'Responsable',
            'RAI_NAME' => 'Nom du raid',
            'RAI_MAIL' => 'Email du contact',
            'RAI_PHONE_NUMBER' => 'Téléphone',
            'RAI_WEB_SITE' => 'Site Web',
            'RAI_IMAGE' => 'Lien image',
            'RAI_TIME_START' => 'Date de début du raid',
            'RAI_TIME_END' => 'Date de fin du raid',
            'RAI_REGISTRATION_START' => 'Début inscriptions',
            'RAI_REGISTRATION_END' => 'Fin inscriptions',
            'RAI_NB_RACES' => 'Nombre de courses',
        ];

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
            'RAI_NB_RACES' => 'required|integer|min:1',
        ], $messages, $attributes);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $club = Club::find($request->CLU_ID);
        if (auth()->user()->USE_ID !== $club->USE_ID && !auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized. Only the club manager can create raids for this club.',
            ], 403);
        }

        $raidData = $request->only([
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
            'RAI_NB_RACES',
        ]);
        
        $raid = Raid::create($raidData);

        return response()->json(['data' => $raid], 201);
    }

    public function updateRaid(Request $request, $id)
    {
        $raid = Raid::with('club')->find($id);
        if (!$raid) {
            return response()->json(['message' => 'Raid not found'], 404);
        }

        if (auth()->user()->USE_ID !== $raid->club->USE_ID && !auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized. Only the club manager can update raids.',
            ], 404);
        }

        // Merge existing raid data with request for validation context
        $dataForValidation = array_merge($raid->toArray(), $request->all());

        $validator = Validator::make($dataForValidation, [
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
        $raid = Raid::with('club')->find($id);
        if (!$raid) {
            return response()->json(['message' => 'Raid not found'], 404);
        }

        if (auth()->user()->USE_ID !== $raid->club->USE_ID && !auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Raid not found',
            ], 404);
        }

        $raid->delete();
        return response()->json(['message' => 'Raid deleted successfully'], 200);
    }
}
