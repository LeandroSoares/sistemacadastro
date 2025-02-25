<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserBasicDataForm extends Component
{
    public ?User $user = null;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $selectedRoles = [];
    public $roles;
    public $isCreating = false;
    public $userRoleId;

    public function mount(?User $user = null)
    {
        $this->user = $user;
        $this->isCreating = !$user;
        
        // Obter o ID da role 'user'
        $userRole = Role::where('name', 'user')->first();
        $this->userRoleId = $userRole?->id;
        
        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
            $this->selectedRoles = $user->roles->pluck('id')->toArray();
        }
        
        // Garantir que a role 'user' esteja sempre selecionada
        if ($this->userRoleId && !in_array($this->userRoleId, $this->selectedRoles)) {
            $this->selectedRoles[] = $this->userRoleId;
        }
        
        // Carregar todas as roles exceto 'user' que será sempre fixa
        $this->roles = Role::where('name', '!=', 'user')->get();
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user?->id)],
            'selectedRoles' => 'array'
        ];

        if ($this->isCreating) {
            $rules['password'] = 'required|min:8|confirmed';
        } else {
            $rules['password'] = 'nullable|min:8|confirmed';
        }

        $validated = $this->validate($rules);

        if ($this->isCreating) {
            $this->user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
        } else {
            $this->user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);

            if ($this->password) {
                $this->user->update(['password' => Hash::make($this->password)]);
            }
        }

        // Garantir que a role 'user' esteja sempre incluída
        if ($this->userRoleId && !in_array($this->userRoleId, $this->selectedRoles)) {
            $this->selectedRoles[] = $this->userRoleId;
        }

        // Buscar as roles pelo ID e pegar os nomes
        $roles = Role::whereIn('id', $this->selectedRoles)->pluck('name');
        
        // Apenas admin pode modificar função de admin
        /** @var User */
        $currentUser = Auth::user();
        if (!$currentUser?->hasRole('admin')) {
            $roles = $roles->reject(function ($role) {
                return $role === 'admin';
            });
        }
        
        // Garantir que 'user' esteja sempre presente
        if (!$roles->contains('user')) {
            $roles->push('user');
        }
        
        $this->user->syncRoles($roles);

        if ($this->isCreating) {
            return redirect()->route('users.index')
                ->with('success', 'Usuário criado com sucesso!');
        }

        $this->dispatch('close-modal', ['name' => 'edit-user-basic']);
        session()->flash('success', 'Dados básicos atualizados com sucesso.');
    }

    public function render()
    {
        return view('livewire.user-basic-data-form');
    }
} 