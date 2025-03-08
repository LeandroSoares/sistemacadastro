<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Amaci;
use Livewire\Component;

class AmaciForm extends Component
{
    public User $user;
    public $type = '';
    public $observations = '';
    public $date = '';
    public $editing = false;
    public $editingAmaciId = null;

    protected $rules = [
        'type' => 'required|string|max:255',
        'observations' => 'nullable|string',
        'date' => 'nullable|date'
    ];

    protected $messages = [
        'type.required' => 'O tipo de amaci é obrigatório',
        'date.date' => 'Data inválida'
    ];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function editAmaci($id)
    {
        $amaci = Amaci::find($id);
        if ($amaci && $amaci->user_id === $this->user->id) {
            $this->editing = true;
            $this->editingAmaciId = $amaci->id;
            $this->type = $amaci->type;
            $this->observations = $amaci->observations;
            $this->date = $amaci->date;
        }
    }

    public function cancelEdit()
    {
        $this->reset(['editing', 'editingAmaciId', 'type', 'observations', 'date']);
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->editing && $this->editingAmaciId) {
            $amaci = Amaci::find($this->editingAmaciId);
            if ($amaci && $amaci->user_id === $this->user->id) {
                $amaci->update($validatedData);
                session()->flash('message', 'Amaci atualizado com sucesso.');
            }
        } else {
            $this->user->amacis()->create($validatedData);
            session()->flash('message', 'Amaci registrado com sucesso.');
            
        }
        $this->dispatch('profile-updated');
        $this->reset(['editing', 'editingAmaciId', 'type', 'observations', 'date']);
    }

    public function deleteAmaci($id)
    {
        $amaci = Amaci::find($id);
        if ($amaci && $amaci->user_id === $this->user->id) {
            $amaci->delete();
            session()->flash('message', 'Amaci removido com sucesso.');
            $this->dispatch('profile-updated');
        }
    }

    public function render()
    {
        return view('livewire.amaci-form', [
            'amacis' => $this->user->amacis()
                ->orderBy('date', 'desc')
                ->get()
        ]);
    }
}
