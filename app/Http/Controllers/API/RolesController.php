<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index(): JsonResponse
    {
        $roles = Role::withCount('permissions')
            ->orderBy('name')
            ->get()
            ->map(fn(Role $role) => [
                'id'               => $role->id,
                'name'             => $role->name,
                'guard_name'       => $role->guard_name,
                'permissions_count'=> $role->permissions_count,
                'created_at'       => $role->created_at?->toDateTimeString(),
            ]);

        return response()->json(['data' => $roles]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:125', 'unique:roles,name'],
            'guard_name'  => ['sometimes', 'string', 'max:125'],
            'permissions' => ['sometimes', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);

        $role = Role::create([
            'name'       => $validated['name'],
            'guard_name' => $validated['guard_name'] ?? 'web',
        ]);

        if (! empty($validated['permissions'])) {
            $role->syncPermissions(
                Permission::whereIn('id', $validated['permissions'])->get()
            );
        }

        return response()->json([
            'message' => 'Role created successfully.',
            'data'    => $role->load('permissions'),
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $role = Role::with('permissions:id,name')->findOrFail($id);

        return response()->json(['data' => $role]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:125', 'unique:roles,name,' . $role->id],
            'guard_name'    => ['sometimes', 'string', 'max:125'],
            'permissions'   => ['sometimes', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);

        $role->update([
            'name'       => $validated['name'],
            'guard_name' => $validated['guard_name'] ?? $role->guard_name,
        ]);

        if (array_key_exists('permissions', $validated)) {
            $role->syncPermissions(
                Permission::whereIn('id', $validated['permissions'])->get()
            );
        }

        return response()->json([
            'message' => 'Role updated successfully.',
            'data'    => $role->load('permissions'),
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully.'], 200);
    }

    public function assignPermissions(Request $request, string $id): JsonResponse
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'permissions'   => ['required', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);

        $role->syncPermissions(
            Permission::whereIn('id', $validated['permissions'])->get()
        );

        return response()->json([
            'message' => 'Permissions assigned successfully.',
            'data'    => $role->load('permissions:id,name'),
        ]);
    }

    public function permissions(): JsonResponse
    {
        $permissions = Permission::orderBy('name')
            ->get(['id', 'name', 'guard_name']);

        return response()->json(['data' => $permissions]);
    }
}
