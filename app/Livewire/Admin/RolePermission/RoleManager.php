<?php

namespace App\Livewire\Admin\RolePermission;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

#[Layout('layouts.app')]
#[Title('Role Management')]
class RoleManager extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;
    public ?int $deleteId = null;

    /** Reset pagination when search changes */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function roles()
    {
        return Role::withCount('permissions')
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy('name')
            ->paginate($this->perPage);
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
        $this->dispatch('open-modal', name: 'confirm-delete');
    }

    public function delete(): void
    {
        if (! $this->deleteId) {
            return;
        }

        $role = Role::findOrFail($this->deleteId);
        $role->delete();

        $this->deleteId = null;
        $this->dispatch('close-modal', name: 'confirm-delete');
        $this->dispatch('role-deleted');

        session()->flash('success', 'Role deleted successfully.');
    }

    public function cancelDelete(): void
    {
        $this->deleteId = null;
    }

    public function render()
    {
        return view('Admin.RolePermission.Role.index');
    }
}
