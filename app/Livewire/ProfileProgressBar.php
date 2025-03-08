<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class ProfileProgressBar extends Component
{
    public $user;
    public $progress;
    public $detailedProgress;
    public $isFixed;

    public function mount($user, $isFixed = false)
    {
        $this->user = $user;
        $this->progress = $user->calculateProfileProgress();
        $this->detailedProgress = $user->getDetailedProgress();
        $this->isFixed = $isFixed;
    }

    #[On('profile-updated')]
    public function refreshProgress()
    {
        $this->progress = $this->user->fresh()->calculateProfileProgress();
        $this->detailedProgress = $this->user->fresh()->getDetailedProgress();
    }

    public function render()
    {
        return view('livewire.profile-progress-bar');
    }
}
