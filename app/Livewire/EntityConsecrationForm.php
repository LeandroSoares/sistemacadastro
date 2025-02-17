<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\EntityConsecration;
use Livewire\Component;

class EntityConsecrationForm extends Component
{
    public User $user;
    public $entity = '';
    public $name = '';
    public $date = '';
    public $editing = false;
    public $editingConsecrationId = null;

    protected $rules = [
        'entity' => 'required|string|max:255',
        'name' => 'nullable|string|max:255',
        'date' => 'nullable|date'
    ];

    protected $messages = [
        'entity.required' => 'A entidade é obrigatória',
        'date.date' => 'Data inválida'
    ];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function editConsecration($id)
    {
        $consecration = EntityConsecration::find($id);
        if ($consecration && $consecration->user_id === $this->user->id) {
            $this->editing = true;
            $this->editingConsecrationId = $consecration->id;
            $this->entity = $consecration->entity;
            $this->name = $consecration->name;
            $this->date = $consecration->date;
        }
    }

    public function cancelEdit()
    {
        $this->reset(['editing', 'editingConsecrationId', 'entity', 'name', 'date']);
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->editing && $this->editingConsecrationId) {
            $consecration = EntityConsecration::find($this->editingConsecrationId);
            if ($consecration && $consecration->user_id === $this->user->id) {
                $consecration->update($validatedData);
                session()->flash('message', 'Consagração atualizada com sucesso.');
            }
        } else {
            $this->user->entityConsecrations()->create($validatedData);
            session()->flash('message', 'Consagração registrada com sucesso.');
        }

        $this->reset(['editing', 'editingConsecrationId', 'entity', 'name', 'date']);
    }

    public function deleteConsecration($id)
    {
        $consecration = EntityConsecration::find($id);
        if ($consecration && $consecration->user_id === $this->user->id) {
            $consecration->delete();
            session()->flash('message', 'Consagração removida com sucesso.');
        }
    }

    public function render()
    {
        return view('livewire.entity-consecration-form', [
            'consecrations' => $this->user->entityConsecrations()
                ->orderBy('date', 'desc')
                ->get()
        ]);
    }
}