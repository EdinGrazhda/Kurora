<?php

namespace App\Livewire\Admin\RolePermission;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

#[Layout('layouts.app')]
#[Title('Assign Permissions')]
class RoleAssignPermissions extends Component
{
    public int $roleId;
    public string $roleName = '';
    public array $selectedPermissions = [];
    public string $search = '';

    public function mount(int $roleId): void
    {
        $role = Role::with('permissions:id')->findOrFail($roleId);

        $this->roleId = $role->id;
        $this->roleName = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('id')->map(fn ($id) => (string) $id)->toArray();
    }

    public function save(): void
    {
        $role = Role::findOrFail($this->roleId);

        $role->syncPermissions(
            Permission::whereIn('id', $this->selectedPermissions)->get()
        );

        session()->flash('success', 'Permissions for "' . $role->name . '" updated successfully.');

        $this->redirect(route('admin.roles.index'), navigate: true);
    }

    public function selectAll(): void
    {
        $this->selectedPermissions = $this->allPermissions->pluck('id')->map(fn ($id) => (string) $id)->toArray();
    }

    public function deselectAll(): void
    {
        $this->selectedPermissions = [];
    }

    #[Computed]
    public function allPermissions()
    {
        return Permission::orderBy('name')
            ->when($this->search, fn ($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->get(['id', 'name']);
    }

    public function render()
    {
        return view('Admin.RolePermission.Role.assign-permissions', [
            'allPermissions' => $this->allPermissions,
        ]);
    }
}
