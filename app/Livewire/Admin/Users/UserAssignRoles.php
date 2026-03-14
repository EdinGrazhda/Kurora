<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Role;

#[Layout('layouts.app')]
#[Title('Assign Roles')]
class UserAssignRoles extends Component
{
    public int $userId;
    public string $userName = '';
    public string $userEmail = '';
    public array $selectedRoles = [];
    public string $search = '';

    public function mount(int $userId): void
    {
        $user = User::with('roles:id')->findOrFail($userId);

        $this->userId        = $user->id;
        $this->userName      = $user->name;
        $this->userEmail     = $user->email;
        $this->selectedRoles = $user->roles->pluck('id')->map(fn ($id) => (string) $id)->toArray();
    }

    public function save(): void
    {
        $user = User::findOrFail($this->userId);

        $user->syncRoles(Role::whereIn('id', $this->selectedRoles)->get());

        session()->flash('success', 'Roles for "' . $user->name . '" updated successfully.');

        $this->redirect(route('admin.users.index'), navigate: true);
    }

    public function selectAll(): void
    {
        $this->selectedRoles = $this->allRoles->pluck('id')->map(fn ($id) => (string) $id)->toArray();
    }

    public function deselectAll(): void
    {
        $this->selectedRoles = [];
    }

    #[Computed]
    public function allRoles()
    {
        return Role::orderBy('name')
            ->when($this->search, fn ($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->get(['id', 'name']);
    }

    public function render()
    {
        return view('Admin.Users.assign-roles', [
            'allRoles' => $this->allRoles,
        ]);
    }
}
