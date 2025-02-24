<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use App\Livewire\Actions\Logout;

class Navigation extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }

    public function render()
    {
        $route_list = ['dashboard', 'meus-dados'];
        return view('livewire.layout.navigation', compact('route_list'));
    }
}
