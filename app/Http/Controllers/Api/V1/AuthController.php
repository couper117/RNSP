<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController
{
    public function register(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|max:255', 'email' => 'required|string|email|unique:users', 'password' => 'required|string|min:8|confirmed']);

        $user = User::create(['name' => $validated['name'], 'email' => $validated['email'], 'password' => Hash::make($validated['password']), 'role' => 'team_manager', 'is_active' => true]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user, 'token' => $user->createToken('auth_token')->plainTextToken], 201);
    }

    public function login(Request $request)
    {
        $validated = $request->validate(['email' => 'required|string|email', 'password' => 'required|string']);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if (!$user->is_active) {
            return response()->json(['message' => 'User account is inactive'], 403);
        }

        return response()->json(['message' => 'Login successful', 'user' => $user, 'token' => $user->createToken('auth_token')->plainTextToken]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
