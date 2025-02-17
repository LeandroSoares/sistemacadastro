<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\MagicType;
use App\Models\DivineMagic;
use Livewire\Component;

class DivineMagicForm extends Component
{
    public User $user;
    public $magic_type_id = '';
    public $date = '';
    public $performed = false;
    public $observations = '';
    public $editing = false;
    public $editingMagicId = null;

    protected $rules = [
        'magic_type_id' => 'required|exists:magic_types,id',
        'date' => 'nullable|date',
        'performed' => 'boolean',
        'observations' => 'nullable|string'
    ];

    protected $messages = [
        'magic_type_id.required' => 'O tipo de magia é obrigatório',
        'magic_type_id.exists' => 'Tipo de magia inválido',
        'date.date' => 'Data inválida'
    ];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function editMagic($id)
    {
        $magic = DivineMagic::find($id);
        if ($magic && $magic->user_id === $this->user->id) {
            $this->editing = true;
            $this->editingMagicId = $magic->id;
            $this->magic_type_id = $magic->magic_type_id;
            $this->date = $magic->date;
            $this->performed = $magic->performed;
            $this->observations = $magic->observations;
        }
    }

    public function cancelEdit()
    {
        $this->reset(['editing', 'editingMagicId', 'magic_type_id', 'date', 'performed', 'observations']);
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->editing && $this->editingMagicId) {
            $magic = DivineMagic::find($this->editingMagicId);
            if ($magic && $magic->user_id === $this->user->id) {
                $magic->update($validatedData);
                session()->flash('message', 'Magia divina atualizada com sucesso.');
            }
        } else {
            $this->user->divineMagics()->create($validatedData);
            session()->flash('message', 'Magia divina registrada com sucesso.');
        }

        $this->reset(['editing', 'editingMagicId', 'magic_type_id', 'date', 'performed', 'observations']);
    }

    public function deleteMagic($id)
    {
        $magic = DivineMagic::find($id);
        if ($magic && $magic->user_id === $this->user->id) {
            $magic->delete();
            session()->flash('message', 'Magia divina removida com sucesso.');
        }
    }

    public function render()
    {
        return view('livewire.divine-magic-form', [
            'divineMagics' => $this->user->divineMagics()
                ->with('magicType')
                ->orderBy('date', 'desc')
                ->get(),
            'availableMagicTypes' => MagicType::where('active', true)
                ->orderBy('name')
                ->get()
        ]);
    }
}
