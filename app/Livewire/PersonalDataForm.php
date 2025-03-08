<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\PersonalData;

class PersonalDataForm extends Component
{
    public User $user;
    public $name = null;
    public $address = null;
    public $zip_code = null;
    public $email = null;
    public $cpf = null;
    public $rg = null;
    public $age = null;
    public $home_phone = null;
    public $mobile_phone = null;
    public $work_phone = null;
    public $emergency_contact = null;

    public function mount(User $user)
    {
        $this->user = $user;

        if ($user->personalData) {
            $this->name = $user->personalData->name;
            $this->address = $user->personalData->address;
            $this->zip_code = $user->personalData->zip_code;
            $this->email = $user->personalData->email;
            $this->cpf = $user->personalData->cpf;
            $this->rg = $user->personalData->rg;
            $this->age = $user->personalData->age;
            $this->home_phone = $user->personalData->home_phone;
            $this->mobile_phone = $user->personalData->mobile_phone;
            $this->work_phone = $user->personalData->work_phone;
            $this->emergency_contact = $user->personalData->emergency_contact;
        }
    }

    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required|min:3',
            'address' => 'required',
            'zip_code' => 'required',
            'email' => 'required|email',
            'cpf' => 'nullable',
            'rg' => 'nullable',
            'age' => 'required|numeric|min:1',
            'mobile_phone' => 'required',
            'emergency_contact' => 'required',
            'home_phone' => 'nullable',
            'work_phone' => 'nullable'
        ]);

        $this->user->personalData()->updateOrCreate(
            ['user_id' => $this->user->id],
            $validatedData
        );

        session()->flash('message', 'Dados pessoais salvos com sucesso.');
        
        $this->dispatch('profile-updated');
    }

    public function render()
    {
        return view('livewire.personal-data-form');
    }
}
