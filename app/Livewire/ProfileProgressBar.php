<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class ProfileProgressBar extends Component
{
    public $user;
    public $progress;
    public $isFixed;

    public function mount($user, $isFixed = false)
    {
        $this->user = $user;
        $this->progress = $user->calculateProfileProgress();
        $this->isFixed = $isFixed;
    }

    #[On('profile-updated')]
    public function refreshProgress()
    {
        $this->progress = $this->user->fresh()->calculateProfileProgress();
    }

    public function render()
    {
        return view('livewire.profile-progress-bar');
    }
}
