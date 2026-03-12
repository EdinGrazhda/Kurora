<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::with('roles:id,name')
            ->orderBy('name')
            ->get()
            ->map(fn (User $user) => [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'roles'      => $user->roles->pluck('name'),
                'created_at' => $user->created_at?->toDateTimeString(),
            ]);

        return response()->json(['data' => $users]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Password::defaults()],
            'roles'    => ['sometimes', 'array'],
            'roles.*'  => ['integer', 'exists:roles,id'],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'],
        ]);

        if (! empty($validated['roles'])) {
            $user->syncRoles(Role::whereIn('id', $validated['roles'])->get());
        }

        return response()->json([
            'message' => 'User created successfully.',
            'data'    => $user->load('roles:id,name'),
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $user = User::with('roles:id,name')->findOrFail($id);

        return response()->json(['data' => $user]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', Password::defaults()],
            'roles'    => ['sometimes', 'array'],
            'roles.*'  => ['integer', 'exists:roles,id'],
        ]);

        $user->update(array_filter([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'] ?? null,
        ]));

        if (array_key_exists('roles', $validated)) {
            $user->syncRoles(Role::whereIn('id', $validated['roles'])->get());
        }

        return response()->json([
            'message' => 'User updated successfully.',
            'data'    => $user->load('roles:id,name'),
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }

    public function assignRoles(Request $request, string $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'roles'   => ['required', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ]);

        $user->syncRoles(Role::whereIn('id', $validated['roles'])->get());

        return response()->json([
            'message' => 'Roles assigned successfully.',
            'data'    => $user->load('roles:id,name'),
        ]);
    }
}
