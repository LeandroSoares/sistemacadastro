<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\HeadOrisha;
use App\Models\Orisha;

class HeadOrishaForm extends Component
{
    public User $user;
    public $ancestor = null;
    public $front = null;
    public $front_together = null;
    public $adjunct = null;
    public $adjunct_together = null;
    public $left_side = null;
    public $left_side_together = null;
    public $right_side = null;
    public $right_side_together = null;
    public $sacredOrishas = [];
    
    public function mount(User $user)
    {
        $this->user = $user;
        $this->sacredOrishas = Orisha::where('active', true)
            ->where('is_right', true)
            ->orderBy('name')
            ->get();
        
        if ($user->orisha) {
            $this->ancestor = $user->orisha->ancestor;
            $this->front = $user->orisha->front;
            $this->front_together = $user->orisha->front_together;
            $this->adjunct = $user->orisha->adjunct;
            $this->adjunct_together = $user->orisha->adjunct_together;
            $this->left_side = $user->orisha->left_side;
            $this->left_side_together = $user->orisha->left_side_together;
            $this->right_side = $user->orisha->right_side;
            $this->right_side_together = $user->orisha->right_side_together;
        }
    }

    public function save()
    {
        $validatedData = $this->validate([
            'ancestor' => 'nullable',
            'front' => 'nullable',
            'front_together' => 'nullable',
            'adjunct' => 'nullable',
            'adjunct_together' => 'nullable',
            'left_side' => 'nullable',
            'left_side_together' => 'nullable',
            'right_side' => 'nullable',
            'right_side_together' => 'nullable'
        ]);

        $this->user->headOrisha()->updateOrCreate(
            ['user_id' => $this->user->id],
            $validatedData
        );

        session()->flash('message', 'Orixás salvos com sucesso.');
    }

    public function render()
    {
        return view('livewire.head-orisha-form');
    }
}
