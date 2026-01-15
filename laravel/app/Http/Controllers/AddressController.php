<?php
namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller{

    public function getAllAddresses()
    {
        $addresses = Address::all();
        return response()->json(['data' => $addresses]);
    }

    public function getAddressById($id)
    {
        $address = Address::find($id);
        if (! $address) {
            return response()->json([
                'message' => 'Address not found',
            ], 404);
        }
        return response()->json(['data' => $address], 200);
    }

    public function createAddress(Request $request)
    {
        $messages = [
            'required' => 'Le champ :attribute est obligatoire.',
            'string' => 'Le champ :attribute doit être une chaîne de caractères.',
            'integer' => 'Le champ :attribute doit être un entier.',
            'max' => 'Le champ :attribute ne doit pas dépasser :max caractères.',
        ];

        $attributes = [
            'ADD_POSTAL_CODE' => 'Code postal',
            'ADD_CITY' => 'Ville',
            'ADD_STREET_NAME' => 'Rue',
            'ADD_STREET_NUMBER' => 'Numéro de rue',
        ];

        $validator = Validator::make($request->all(), [
            'ADD_POSTAL_CODE' => 'required|integer|max:99999',
            'ADD_CITY' => 'required|string|max:100',
            'ADD_STREET_NAME' => 'nullable|string|max:255',
            'ADD_STREET_NUMBER' => 'nullable|string|max:20'
        ], $messages, $attributes);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $address = Address::create($request->only([
            'ADD_POSTAL_CODE',
            'ADD_CITY',
            'ADD_STREET_NAME',
            'ADD_STREET_NUMBER'
        ]));

        return response()->json(['data' => $address], 201);
    }

    public function updateAddress(Request $request, $id)
    {
        $address = Address::find($id);
        if (! $address) {
            return response()->json([
                'message' => 'Address not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'ADD_POSTAL_CODE' => 'sometimes|integer|max:99999',
            'ADD_CITY' => 'sometimes|string|max:100',
            'ADD_STREET_NAME' => 'sometimes|string|max:255',
            'ADD_STREET_NUMBER' => 'sometimes|string|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $address->update($request->only([
            'ADD_POSTAL_CODE',
            'ADD_CITY',
            'ADD_STREET_NAME',
            'ADD_STREET_NUMBER'
        ]));

        return response()->json(['data' => $address], 200);
    }

    public function deleteAddress($id)
    {
        $address = Address::find($id);
        if (! $address) {
            return response()->json([
                'message' => 'Address not found',
            ], 404);
        }

        $address->delete();

        return response()->json(['message' => 'Address deleted successfully'], 200);
    }
}