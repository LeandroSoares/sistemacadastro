<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\ReligiousInfo;

class ReligiousInfoForm extends Component
{
    public User $user;
    public $start_date = null;
    public $start_location = null;
    public $charity_house_start = null;
    public $charity_house_end = null;
    public $charity_house_observations = null;
    public $development_start = null;
    public $development_end = null;
    public $service_start = null;
    public $umbanda_baptism = null;
    public $cambone_experience = false;
    public $cambone_start_date = null;
    public $cambone_end_date = null;

    public function mount(User $user)
    {
        $this->user = $user;
        // try {
        //     $user->load('religiousInfo');
        // } catch (\Exception $e) {
        //     $user->religiousInfo = new ReligiousInfo();
        // }

        if ($user->religiousInfo) {
            $this->start_date = $user->religiousInfo->start_date;
            $this->start_location = $user->religiousInfo->start_location;
            $this->charity_house_start = $user->religiousInfo->charity_house_start;
            $this->charity_house_end = $user->religiousInfo->charity_house_end;
            $this->charity_house_observations = $user->religiousInfo->charity_house_observations;
            $this->development_start = $user->religiousInfo->development_start;
            $this->development_end = $user->religiousInfo->development_end;
            $this->service_start = $user->religiousInfo->service_start;
            $this->umbanda_baptism = $user->religiousInfo->umbanda_baptism;
            $this->cambone_experience = $user->religiousInfo->cambone_experience;
            $this->cambone_start_date = $user->religiousInfo->cambone_start_date;
            $this->cambone_end_date = $user->religiousInfo->cambone_end_date;
        }
    }

    public function save()
    {
        $validatedData = $this->validate([
            'start_date' => 'required|date',
            'start_location' => 'required',
            'charity_house_start' => 'required|date',
            'charity_house_end' => 'nullable|date',
            'charity_house_observations' => 'nullable',
            'development_start' => 'nullable|date',
            'development_end' => 'nullable|date',
            'service_start' => 'nullable|date',
            'umbanda_baptism' => 'nullable|date',
            'cambone_experience' => 'boolean',
            'cambone_start_date' => 'nullable|date',
            'cambone_end_date' => 'nullable|date'
        ]);

        $this->user->religiousInfo()->updateOrCreate(
            ['user_id' => $this->user->id],
            $validatedData
        );

        session()->flash('message', 'Informações religiosas salvas com sucesso.');
    }

    public function render()
    {
        return view('livewire.religious-info-form');
    }
}
