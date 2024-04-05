<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'roles' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Create user
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->roles = $request->input('roles');
        $user->save();

        return response()->json($user, 201);
    }

    public function index(Request $request, $role)
    {
        // Fetch users by role
        $users = User::where('roles', $role)->get();

        return response()->json($users, 200);
    }
}
