<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;

class UserController
{
    public function index(Request $request)
    {
        if ($request->user()->role !== 'superadmin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $query = User::query();

        if ($request->has('role')) {
            $query->where('role', $request->role);
        }

        if ($request->has('federation_id')) {
            $query->where('federation_id', $request->federation_id);
        }

        return response()->json($query->paginate(50));
    }

    public function show(User $user)
    {
        if ($user->id !== auth()->id() && auth()->user()->role !== 'superadmin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        if ($user->id !== $request->user()->id && $request->user()->role !== 'superadmin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate(['name' => 'sometimes|string|max:255', 'email' => 'sometimes|string|email|unique:users,email,' . $user->id, 'is_active' => 'sometimes|boolean']);

        $user->update($validated);

        return response()->json($user);
    }

    public function deactivate(Request $request, User $user)
    {
        if ($request->user()->role !== 'superadmin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user->update(['is_active' => false]);

        return response()->json(['message' => 'User deactivated']);
    }
}
