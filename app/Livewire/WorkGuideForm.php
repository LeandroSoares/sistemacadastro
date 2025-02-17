<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\WorkGuide;

class WorkGuideForm extends Component
{
    public User $user;
    public $caboclo = null;
    public $cabocla = null;
    public $ogum = null;
    public $xango = null;
    public $baiano = null;
    public $baiana = null;
    public $preto_velho = null;
    public $preta_velha = null;
    public $boiadeiro = null;
    public $boiadeira = null;
    public $cigano = null;
    public $cigana = null;
    public $marinheiro = null;
    public $ere = null;
    public $exu = null;
    public $pombagira = null;
    public $exu_mirim = null;

    public function mount(User $user)
    {
        $this->user = $user;
        
        if ($user->workGuide) {
            $this->caboclo = $user->workGuide->caboclo;
            $this->cabocla = $user->workGuide->cabocla;
            $this->ogum = $user->workGuide->ogum;
            $this->xango = $user->workGuide->xango;
            $this->baiano = $user->workGuide->baiano;
            $this->baiana = $user->workGuide->baiana;
            $this->preto_velho = $user->workGuide->preto_velho;
            $this->preta_velha = $user->workGuide->preta_velha;
            $this->boiadeiro = $user->workGuide->boiadeiro;
            $this->boiadeira = $user->workGuide->boiadeira;
            $this->cigano = $user->workGuide->cigano;
            $this->cigana = $user->workGuide->cigana;
            $this->marinheiro = $user->workGuide->marinheiro;
            $this->ere = $user->workGuide->ere;
            $this->exu = $user->workGuide->exu;
            $this->pombagira = $user->workGuide->pombagira;
            $this->exu_mirim = $user->workGuide->exu_mirim;
        }
    }

    public function save()
    {
        $validatedData = $this->validate([
            'caboclo' => 'nullable|string',
            'cabocla' => 'nullable|string',
            'ogum' => 'nullable|string',
            'xango' => 'nullable|string',
            'baiano' => 'nullable|string',
            'baiana' => 'nullable|string',
            'preto_velho' => 'nullable|string',
            'preta_velha' => 'nullable|string',
            'boiadeiro' => 'nullable|string',
            'boiadeira' => 'nullable|string',
            'cigano' => 'nullable|string',
            'cigana' => 'nullable|string',
            'marinheiro' => 'nullable|string',
            'ere' => 'nullable|string',
            'exu' => 'nullable|string',
            'pombagira' => 'nullable|string',
            'exu_mirim' => 'nullable|string'
        ]);

        $this->user->workGuide()->updateOrCreate(
            ['user_id' => $this->user->id],
            $validatedData
        );

        session()->flash('message', 'Guias de trabalho salvos com sucesso.');
    }

    public function render()
    {
        return view('livewire.work-guide-form');
    }
}
