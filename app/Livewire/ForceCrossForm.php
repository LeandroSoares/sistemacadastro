<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\ForceCross;
use Livewire\Component;

class ForceCrossForm extends Component
{
    public User $user;
    public $top = '';
    public $bottom = '';
    public $left = '';
    public $right = '';

    protected $rules = [
        'top' => 'nullable|string|max:255',
        'bottom' => 'nullable|string|max:255',
        'left' => 'nullable|string|max:255',
        'right' => 'nullable|string|max:255'
    ];

    protected $messages = [
        'top.max' => 'O campo superior não pode ter mais que 255 caracteres',
        'bottom.max' => 'O campo inferior não pode ter mais que 255 caracteres',
        'left.max' => 'O campo esquerdo não pode ter mais que 255 caracteres',
        'right.max' => 'O campo direito não pode ter mais que 255 caracteres'
    ];

    public function mount(User $user)
    {
        $this->user = $user;

        if ($user->forceCross) {
            $this->top = $user->forceCross->top;
            $this->bottom = $user->forceCross->bottom;
            $this->left = $user->forceCross->left;
            $this->right = $user->forceCross->right;
        }
    }

    public function save()
    {
        $validatedData = $this->validate();

        $this->user->forceCross()->updateOrCreate(
            ['user_id' => $this->user->id],
            $validatedData
        );

        session()->flash('message', 'Cruz de força salva com sucesso.');
    }

    public function render()
    {
        return view('livewire.force-cross-form');
    }
}
