<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Orisha;
use App\Models\InitiatedOrisha;
use Livewire\Component;

class InitiatedOrishaForm extends Component
{
    public User $user;
    public $orisha_id = '';
    public $initiated = false;
    public $observations = '';
    public $editing = false;
    public $editingOrishaId = null;

    protected $rules = [
        'orisha_id' => 'required|exists:orishas,id',
        'initiated' => 'boolean',
        'observations' => 'nullable|string'
    ];

    protected $messages = [
        'orisha_id.required' => 'O orixá é obrigatório',
        'orisha_id.exists' => 'Orixá inválido'
    ];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function editOrisha($id)
    {
        $orisha = InitiatedOrisha::find($id);
        if ($orisha && $orisha->user_id === $this->user->id) {
            $this->editing = true;
            $this->editingOrishaId = $orisha->id;
            $this->orisha_id = $orisha->orisha_id;
            $this->initiated = $orisha->initiated;
            $this->observations = $orisha->observations;
        }
    }

    public function cancelEdit()
    {
        $this->reset(['editing', 'editingOrishaId', 'orisha_id', 'initiated', 'observations']);
    }

    public function save()
    {
        // Usa as regras definidas na propriedade $rules
        $validatedData = $this->validate();
    
        if ($this->editing && $this->editingOrishaId) {
            $orisha = InitiatedOrisha::find($this->editingOrishaId);
            if ($orisha && $orisha->user_id === $this->user->id) {
                $orisha->update($validatedData);
                session()->flash('message', 'Orixá atualizado com sucesso.');
            }
        } else {
            // Garante que todos os campos obrigatórios estejam presentes
            $this->user->initiatedOrishas()->create([
                'orisha_id' => $validatedData['orisha_id'],
                'initiated' => $validatedData['initiated'],
                'observations' => $validatedData['observations']
            ]);
            session()->flash('message', 'Orixá iniciado registrado com sucesso.');
        }
        $this->dispatch('profile-updated');
        $this->reset(['editing', 'editingOrishaId', 'orisha_id', 'initiated', 'observations']);
    }
    

    public function deleteOrisha($id)
    {
        $orisha = InitiatedOrisha::find($id);
        if ($orisha && $orisha->user_id === $this->user->id) {
            $orisha->delete();
            session()->flash('message', 'Orixá removido com sucesso.');
        }
    }

    public function render()
    {
        return view('livewire.initiated-orisha-form', [
            'initiatedOrishas' => $this->user->initiatedOrishas()
                ->with('orisha')
                ->orderBy('created_at', 'desc')
                ->get(),
            'availableOrishas' => Orisha::where('active', true)
                ->orderBy('name')
                ->get()
        ]);
    }
}
