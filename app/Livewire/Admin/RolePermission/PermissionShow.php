<?php

namespace App\Livewire\Admin\RolePermission;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

#[Layout('layouts.app')]
#[Title('Permission Show')]
class PermissionShow extends Component
{
    public int $permissionId;
    public Permission $permission;

    public function mount(int $permissionId): void
    {
        $this->permissionId = $permissionId;
        $this->permission   = Permission::with('roles:id,name')->findOrFail($permissionId);
    }

    public function render()
    {
        return view('Admin.RolePermission.Permission.show');
    }
}
