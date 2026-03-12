<?php

namespace App\Livewire\Admin\RolePermission;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

#[Layout('layouts.app')]
#[Title('Permission Edit')]
class PermissionEdit extends Component
{
    public int $permissionId;

    #[Validate('required|string|max:125')]
    public string $name = '';

    #[Validate('required|string|max:125')]
    public string $guardName = 'web';

    public function mount(int $permissionId): void
    {
        $permission = Permission::findOrFail($permissionId);

        $this->permissionId = $permission->id;
        $this->name         = $permission->name;
        $this->guardName    = $permission->guard_name;
    }

    public function update(): void
    {
        $this->validate([
            'name'      => 'required|string|max:125|unique:permissions,name,' . $this->permissionId,
            'guardName' => 'required|string|max:125',
        ]);

        $permission = Permission::findOrFail($this->permissionId);

        $permission->update([
            'name'       => $this->name,
            'guard_name' => $this->guardName,
        ]);

        session()->flash('success', 'Permission "' . $permission->name . '" updated successfully.');

        $this->redirect(route('admin.permissions.index'), navigate: true);
    }

    public function render()
    {
        return view('Admin.RolePermission.Permission.edit');
    }
}
