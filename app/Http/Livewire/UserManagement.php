<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class UserManagement extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::with('roles')->get();
    }

    public function render()
    {
        return view('livewire.user-management', ['users' => $this->users]);
    }
}
