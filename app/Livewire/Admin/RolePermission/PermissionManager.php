<?php

namespace App\Livewire\Admin\RolePermission;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

#[Layout('layouts.app')]
#[Title('Permission Management')]
class PermissionManager extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;
    public ?int $deleteId = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function permissions()
    {
        return Permission::withCount('roles')
            ->when($this->search, fn ($q) => $q->where('name', 'like', '%' . $this->search . '%'))
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

        $permission = Permission::findOrFail($this->deleteId);
        $permission->delete();

        $this->deleteId = null;
        $this->dispatch('close-modal', name: 'confirm-delete');

        session()->flash('success', 'Permission deleted successfully.');
    }

    public function cancelDelete(): void
    {
        $this->deleteId = null;
    }

    public function render()
    {
        return view('Admin.RolePermission.Permission.index');
    }
}
