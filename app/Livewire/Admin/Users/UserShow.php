<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('User Details')]
class UserShow extends Component
{
    public int $userId;
    public User $user;

    public function mount(int $userId): void
    {
        $this->userId = $userId;
        $this->user   = User::with('roles:id,name', 'permissions:id,name')->findOrFail($userId);
    }

    public function render()
    {
        return view('Admin.Users.show');
    }
}
