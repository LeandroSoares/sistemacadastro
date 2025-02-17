<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\PriestlyFormation;

class PriestlyFormationForm extends Component
{
    public User $user;
    public $theology_start = null;
    public $theology_end = null;
    public $priesthood_start = null;
    public $priesthood_end = null;
    
    public function mount(User $user)
    {
        $this->user = $user;
        
        if ($user->priestlyFormation) {
            $this->theology_start = $user->priestlyFormation->theology_start;
            $this->theology_end = $user->priestlyFormation->theology_end;
            $this->priesthood_start = $user->priestlyFormation->priesthood_start;
            $this->priesthood_end = $user->priestlyFormation->priesthood_end;
        }
    }

    public function save()
    {
        $validatedData = $this->validate([
            'theology_start' => 'required|date',
            'theology_end' => 'nullable|date',
            'priesthood_start' => 'required|date',
            'priesthood_end' => 'nullable|date'
        ]);

        $this->user->priestlyFormation()->updateOrCreate(
            ['user_id' => $this->user->id],
            $validatedData
        );

        session()->flash('message', 'Formação sacerdotal salva com sucesso.');
    }

    public function render()
    {
        return view('livewire.priestly-formation-form');
    }
}