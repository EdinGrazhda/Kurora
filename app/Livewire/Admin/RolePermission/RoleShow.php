<?php

namespace App\Livewire\Admin\RolePermission;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Role;

#[Layout('layouts.app')]
#[Title('Role Show')]
class RoleShow extends Component
{
    public int $roleId;
    public Role $role;

    public function mount(int $roleId): void
    {
        $this->roleId = $roleId;
        $this->role   = Role::with('permissions:id,name')->findOrFail($roleId);
    }

    public function render()
    {
        return view('Admin.RolePermission.Role.show');
    }
}
