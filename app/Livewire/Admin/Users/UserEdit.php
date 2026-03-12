<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

#[Layout('layouts.app')]
#[Title('Edit User')]
class UserEdit extends Component
{
    public int $userId;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|email|max:255')]
    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public array $selectedRoles = [];

    public function mount(int $userId): void
    {
        $user = User::with('roles:id')->findOrFail($userId);

        $this->userId        = $user->id;
        $this->name          = $user->name;
        $this->email         = $user->email;
        $this->selectedRoles = $user->roles->pluck('id')->map(fn ($id) => (string) $id)->toArray();
    }

    public function update(): void
    {
        $this->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $this->userId,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($this->userId);

        $data = [
            'name'  => $this->name,
            'email' => $this->email,
        ];

        if ($this->password !== '') {
            $data['password'] = $this->password;
        }

        $user->update($data);
        $user->syncRoles(Role::whereIn('id', $this->selectedRoles)->get());

        session()->flash('success', 'User "' . $user->name . '" updated successfully.');

        $this->redirect(route('admin.users.index'), navigate: true);
    }

    public function render()
    {
        return view('Admin.Users.edit', [
            'allRoles' => Role::orderBy('name')->get(['id', 'name']),
        ]);
    }
}
