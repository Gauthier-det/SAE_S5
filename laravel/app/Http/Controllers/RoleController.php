<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function getAllRoles()
    {
        $roles = Role::all();

        return response()->json(['data' => $roles]);
    }

    public function getRoleById($id)
    {
        $role = Role::find($id);

        if (! $role) {
            return response()->json([
                'message' => 'Role not found',
            ], 404);
        }

        return response()->json(['data' => $role], 200);
    }

    public function createRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ROL_NAME' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $role = Role::create($request->only([
            'ROL_NAME',
        ]));

        return response()->json(['data' => $role], 201);
    }
}
