<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\LastTemple;
use Livewire\Component;

class LastTempleForm extends Component
{
    public User $user;
    public $name = '';
    public $address = '';
    public $leader_name = '';
    public $function = '';
    public $exit_reason = '';

    protected $rules = [
        'name' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'leader_name' => 'nullable|string|max:255',
        'function' => 'nullable|string|max:255',
        'exit_reason' => 'nullable|string|max:255'
    ];

    protected $messages = [
        'name.required' => 'O nome do templo é obrigatório'
    ];

    public function mount(User $user)
    {
        $this->user = $user;

        if ($user->lastTemple) {
            $this->name = $user->lastTemple->name;
            $this->address = $user->lastTemple->address;
            $this->leader_name = $user->lastTemple->leader_name;
            $this->function = $user->lastTemple->function;
            $this->exit_reason = $user->lastTemple->exit_reason;
        }
    }

    public function save()
    {
        $validatedData = $this->validate();

        // Converter strings vazias em null
        foreach ($validatedData as $key => $value) {
            if ($value === '') {
                $validatedData[$key] = null;
            }
        }

        $this->user->lastTemple()->updateOrCreate(
            ['user_id' => $this->user->id],
            $validatedData
        );

        session()->flash('message', 'Último templo salvo com sucesso.');
        $this->dispatch('profile-updated');
    }

    public function render()
    {
        return view('livewire.last-temple-form');
    }
}
