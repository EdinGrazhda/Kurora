<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    public function index(): JsonResponse
    {
        $permissions = Permission::orderBy('name')
            ->get(['id', 'name', 'guard_name', 'created_at']);

        return response()->json(['data' => $permissions]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:125', 'unique:permissions,name'],
            'guard_name' => ['sometimes', 'string', 'max:125'],
        ]);

        $permission = Permission::create([
            'name'       => $validated['name'],
            'guard_name' => $validated['guard_name'] ?? 'web',
        ]);

        return response()->json([
            'message' => 'Permission created successfully.',
            'data'    => $permission,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $permission = Permission::with('roles:id,name')->findOrFail($id);

        return response()->json(['data' => $permission]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $permission = Permission::findOrFail($id);

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:125', 'unique:permissions,name,' . $permission->id],
            'guard_name' => ['sometimes', 'string', 'max:125'],
        ]);

        $permission->update([
            'name'       => $validated['name'],
            'guard_name' => $validated['guard_name'] ?? $permission->guard_name,
        ]);

        return response()->json([
            'message' => 'Permission updated successfully.',
            'data'    => $permission,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return response()->json(['message' => 'Permission deleted successfully.']);
    }
}
