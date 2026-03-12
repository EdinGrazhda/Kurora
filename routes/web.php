<?php

use App\Livewire\Admin\RolePermission\PermissionCreate;
use App\Livewire\Admin\RolePermission\PermissionEdit;
use App\Livewire\Admin\RolePermission\PermissionManager;
use App\Livewire\Admin\RolePermission\PermissionShow;
use App\Livewire\Admin\RolePermission\RoleAssignPermissions;
use App\Livewire\Admin\RolePermission\RoleCreate;
use App\Livewire\Admin\RolePermission\RoleEdit;
use App\Livewire\Admin\RolePermission\RoleManager;
use App\Livewire\Admin\RolePermission\RoleShow;
use App\Livewire\Admin\Users\UserAssignRoles;
use App\Livewire\Admin\Users\UserCreate;
use App\Livewire\Admin\Users\UserEdit;
use App\Livewire\Admin\Users\UserManager;
use App\Livewire\Admin\Users\UserShow;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin – Role Management
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('roles', RoleManager::class)->name('roles.index');
    Route::get('roles/create', RoleCreate::class)->name('roles.create');
    Route::get('roles/{roleId}', RoleShow::class)->name('roles.show');
    Route::get('roles/{roleId}/edit', RoleEdit::class)->name('roles.edit');
    Route::get('roles/{roleId}/permissions', RoleAssignPermissions::class)->name('roles.permissions');

    Route::get('permissions', PermissionManager::class)->name('permissions.index');
    Route::get('permissions/create', PermissionCreate::class)->name('permissions.create');
    Route::get('permissions/{permissionId}', PermissionShow::class)->name('permissions.show');
    Route::get('permissions/{permissionId}/edit', PermissionEdit::class)->name('permissions.edit');

    Route::get('users', UserManager::class)->name('users.index');
    Route::get('users/create', UserCreate::class)->name('users.create');
    Route::get('users/{userId}', UserShow::class)->name('users.show');
    Route::get('users/{userId}/edit', UserEdit::class)->name('users.edit');
    Route::get('users/{userId}/roles', UserAssignRoles::class)->name('users.roles');
});

require __DIR__.'/settings.php';
