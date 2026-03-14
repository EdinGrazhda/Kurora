<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

#[Layout('layouts.app')]
#[Title('Create User')]
class UserCreate extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|email|max:255|unique:users,email')]
    public string $email = '';

    #[Validate('required|string|min:8|confirmed')]
    public string $password = '';

    public string $password_confirmation = '';

    public array $selectedRoles = [];

    public function save(): void
    {
        $this->validate();

        $user = User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => $this->password,
        ]);

        if (count($this->selectedRoles) > 0) {
            $user->syncRoles(Role::whereIn('id', $this->selectedRoles)->get());
        }

        session()->flash('success', 'User "' . $user->name . '" created successfully.');

        $this->redirect(route('admin.users.index'), navigate: true);
    }

    #[Computed]
    public function allRoles()
    {
        return Role::orderBy('name')->get(['id', 'name']);
    }

    public function render()
    {
        return view('Admin.Users.create', [
            'allRoles' => $this->allRoles,
        ]);
    }
}
