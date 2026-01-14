<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function createAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ADD_POSTAL_CODE' => 'required|integer',
            'ADD_CITY' => 'required|string|max:255',
            'ADD_STREET_NAME' => 'required|string|max:255',
            'ADD_STREET_NUMBER' => 'required|string|max:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $address = Address::create($request->all());

        return response()->json(['data' => $address], 201);
    }
}
