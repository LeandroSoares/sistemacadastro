<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Crossing;

class CrossingForm extends Component
{
    public User $user;
    public $entity = '';
    public $date = '';
    public $purpose = '';
    
    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function save()
    {
        $validatedData = $this->validate([
            'entity' => 'required|string',
            'date' => 'required|date',
            'purpose' => 'required|string'
        ]);

        $this->user->crossings()->create($validatedData);

        session()->flash('message', 'Cruzamento adicionado com sucesso.');
        
        $this->reset(['entity', 'date', 'purpose']);
    }

    public function deleteCrossing($id)
    {
        $crossing = Crossing::find($id);
        if ($crossing && $crossing->user_id === $this->user->id) {
            $crossing->delete();
            session()->flash('message', 'Cruzamento removido com sucesso.');
        }
    }

    public function render()
    {
        return view('livewire.crossing-form', [
            'crossings' => $this->user->crossings()->orderBy('date', 'desc')->get()
        ]);
    }
}
