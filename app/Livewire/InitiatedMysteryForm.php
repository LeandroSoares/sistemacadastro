<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Mystery;
use App\Models\InitiatedMystery;
use Livewire\Component;

class InitiatedMysteryForm extends Component
{
    public User $user;
    public $mystery_id = '';
    public $date = '';
    public $completed = false;
    public $observations = '';
    public $editing = false;
    public $editingMysteryId = null;

    protected $rules = [
        'mystery_id' => 'required|exists:mysteries,id',
        'date' => 'nullable|date',
        'completed' => 'boolean',
        'observations' => 'nullable|string'
    ];

    protected $messages = [
        'mystery_id.required' => 'O mistério é obrigatório',
        'mystery_id.exists' => 'Mistério inválido',
        'date.date' => 'Data inválida'
    ];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function editMystery($id)
    {
        $mystery = InitiatedMystery::find($id);
        if ($mystery && $mystery->user_id === $this->user->id) {
            $this->editing = true;
            $this->editingMysteryId = $mystery->id;
            $this->mystery_id = $mystery->mystery_id;
            $this->date = $mystery->date;
            $this->completed = $mystery->completed;
            $this->observations = $mystery->observations;
        }
    }

    public function cancelEdit()
    {
        $this->reset(['editing', 'editingMysteryId', 'mystery_id', 'date', 'completed', 'observations']);
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->editing && $this->editingMysteryId) {
            $mystery = InitiatedMystery::find($this->editingMysteryId);
            if ($mystery && $mystery->user_id === $this->user->id) {
                $mystery->update($validatedData);
                session()->flash('message', 'Mistério atualizado com sucesso.');
            }
        } else {
            $this->user->initiatedMysteries()->create($validatedData);
            session()->flash('message', 'Mistério iniciado registrado com sucesso.');
        }

        $this->reset(['editing', 'editingMysteryId', 'mystery_id', 'date', 'completed', 'observations']);
    }
    public function deleteMystery($id)
    {
        $mystery = InitiatedMystery::find($id);
        if ($mystery && $mystery->user_id === $this->user->id) {
            $mystery->delete();
            session()->flash('message', 'Mistério removido com sucesso.');
        }
    }

    public function render()
    {
        return view('livewire.initiated-mystery-form', [
            'mysteries' => $this->user->initiatedMysteries()
                ->with('mystery')
                ->orderBy('date', 'desc')
                ->get(),
            'availableMysteries' => Mystery::where('active', true)
                ->orderBy('name')
                ->get()
        ]);
    }
}
