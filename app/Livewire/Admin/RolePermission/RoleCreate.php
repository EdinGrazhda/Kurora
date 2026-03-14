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
#[Title('Role Create')]
class RoleCreate extends Component
{
    #[Validate('required|string|max:125|unique:roles,name')]
    public string $name = '';

    #[Validate('required|string|max:125')]
    public string $guardName = 'web';

    public array $selectedPermissions = [];

    public function mount(): void
    {
        // eagerly available for the view via allPermissions()
    }

    #[Computed]
    public function allPermissions()
    {
        return Permission::orderBy('name')->get(['id', 'name']);
    }

    public function selectAll(): void
    {
        $this->selectedPermissions = $this->allPermissions->pluck('id')->map(fn ($id) => (string) $id)->toArray();
    }

    public function deselectAll(): void
    {
        $this->selectedPermissions = [];
    }

    public function save(): void
    {
        $this->validate();

        $role = Role::create([
            'name'       => $this->name,
            'guard_name' => $this->guardName,
        ]);

        if (count($this->selectedPermissions) > 0) {
            $role->syncPermissions(
                Permission::whereIn('id', $this->selectedPermissions)->get()
            );
        }

        session()->flash('success', 'Role "' . $role->name . '" created successfully.');

        $this->redirect(route('admin.roles.index'), navigate: true);
    }

    public function render()
    {
        return view('Admin.RolePermission.Role.create', [
            'allPermissions' => $this->allPermissions,
        ]);
    }
}
