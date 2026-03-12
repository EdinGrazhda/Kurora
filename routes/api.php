<?php

use App\Http\Controllers\API\PermissionsController;
use App\Http\Controllers\API\RolesController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('roles/permissions', [RolesController::class, 'permissions']);
    Route::put('roles/{role}/permissions', [RolesController::class, 'assignPermissions']);
    Route::apiResource('roles', RolesController::class);

    Route::apiResource('permissions', PermissionsController::class);

    Route::put('users/{user}/roles', [UserController::class, 'assignRoles']);
    Route::apiResource('users', UserController::class);
});
