<?php

namespace App\Livewire\Admin\RolePermission;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

#[Layout('layouts.app')]
#[Title('Role Edit')]
class RoleEdit extends Component
{
    public int $roleId;

    #[Validate('required|string|max:125')]
    public string $name = '';

    #[Validate('required|string|max:125')]
    public string $guardName = 'web';

    public array $selectedPermissions = [];

    private ?Role $role = null;

    public function mount(int $roleId): void
    {
        $this->roleId = $roleId;
        $this->role   = Role::with('permissions')->findOrFail($roleId);

        $this->name               = $this->role->name;
        $this->guardName          = $this->role->guard_name;
        $this->selectedPermissions = $this->role->permissions->pluck('id')->map(fn($id) => (string) $id)->toArray();
    }

    #[Computed]
    public function allPermissions()
    {
        return Permission::orderBy('name')->get(['id', 'name']);
    }

    public function update(): void
    {
        $this->validate([
            'name'      => 'required|string|max:125|unique:roles,name,' . $this->roleId,
            'guardName' => 'required|string|max:125',
        ]);

        $role = Role::findOrFail($this->roleId);

        $role->update([
            'name'       => $this->name,
            'guard_name' => $this->guardName,
        ]);

        $role->syncPermissions(
            Permission::whereIn('id', $this->selectedPermissions)->get()
        );

        session()->flash('success', 'Role "' . $role->name . '" updated successfully.');

        $this->redirect(route('admin.roles.index'), navigate: true);
    }

    public function render()
    {
        return view('Admin.RolePermission.Role.edit', [
            'allPermissions' => $this->allPermissions,
        ]);
    }
}
