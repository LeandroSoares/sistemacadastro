<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Crowning;

class CrowningForm extends Component
{
    public User $user;
    public $start_date = null;
    public $end_date = null;
    public $guide_name = null;
    public $priest_name = null;
    public $temple_name = null;
    
    public function mount(User $user)
    {
        $this->user = $user;
        
        if ($user->crowning) {
            $this->start_date = $user->crowning->start_date;
            $this->end_date = $user->crowning->end_date;
            $this->guide_name = $user->crowning->guide_name;
            $this->priest_name = $user->crowning->priest_name;
            $this->temple_name = $user->crowning->temple_name;
        }
    }

    public function save()
    {
        $validatedData = $this->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'guide_name' => 'required',
            'priest_name' => 'required',
            'temple_name' => 'required'
        ]);

        $this->user->crowning()->updateOrCreate(
            ['user_id' => $this->user->id],
            $validatedData
        );

        session()->flash('message', 'Dados da coroação salvos com sucesso.');
    }

    public function render()
    {
        return view('livewire.crowning-form');
    }
}