<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Navigation extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }

    public function render()
    {
        $route_list = ['dashboard', 'meus-dados','courses.index'];
        /** @var User */
        $user = Auth::user();
        
        if ($user && $user->hasAnyRole(['admin', 'manager'])) {
            $route_list[] = 'users.index';
        }

        return view('livewire.layout.navigation', [
            'route_list' => $route_list,
            'user' => $user
        ]);
    }
}
