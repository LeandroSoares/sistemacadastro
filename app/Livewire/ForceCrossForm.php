<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\ForceCross;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ForceCrossForm extends Component
{
    private const FIELDS = [
        'top',
        'bottom',
        'left',
        'right'
    ];

    private const VALIDATION_RULE = 'nullable|string|max:255';

    public User $user;
    public $top = '';
    public $bottom = '';
    public $left = '';
    public $right = '';

    protected $rules;

    public function __construct()
    {
        $this->rules = array_fill_keys(self::FIELDS, self::VALIDATION_RULE);
    }

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

        try {
            $this->user->forceCross()->updateOrCreate(
                ['user_id' => $this->user->id],
                [
                    'top' => $validatedData['top'],
                    'bottom' => $validatedData['bottom'],
                    'left' => $validatedData['left'],
                    'right' => $validatedData['right']
                ]
            );

            session()->flash('message', 'Cruz de força salva com sucesso.');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao salvar a cruz de força.');
        }
        $this->dispatch('profile-updated');
    }

    public function render()
    {
        return view('livewire.force-cross-form');
    }
}
