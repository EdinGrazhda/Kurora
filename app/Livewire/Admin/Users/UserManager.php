<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('User Management')]
class UserManager extends Component
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
    public function users()
    {
        return User::with('roles:id,name')
            ->when($this->search, fn ($q) => $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%'))
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

        $user = User::findOrFail($this->deleteId);
        $user->delete();

        $this->deleteId = null;
        $this->dispatch('close-modal', name: 'confirm-delete');

        session()->flash('success', 'User deleted successfully.');
    }

    public function cancelDelete(): void
    {
        $this->deleteId = null;
    }

    public function render()
    {
        return view('Admin.Users.index');
    }
}
