<?php

namespace App\Livewire\Admin\RolePermission;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

#[Layout('layouts.app')]
#[Title('Permission Create')]
class PermissionCreate extends Component
{
    #[Validate('required|string|max:125|unique:permissions,name')]
    public string $name = '';

    #[Validate('required|string|max:125')]
    public string $guardName = 'web';

    public function save(): void
    {
        $this->validate();

        $permission = Permission::create([
            'name'       => $this->name,
            'guard_name' => $this->guardName,
        ]);

        session()->flash('success', 'Permission "' . $permission->name . '" created successfully.');

        $this->redirect(route('admin.permissions.index'), navigate: true);
    }

    public function render()
    {
        return view('Admin.RolePermission.Permission.create');
    }
}
