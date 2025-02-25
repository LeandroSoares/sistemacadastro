<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UsersList extends Component
{
    use WithPagination;

    public $search = '';
    public $canDelete;
    public $perPage = 10;
    public $perPageOptions = [10, 25, 50, 100];

    public function mount()
    {
        /** @var User */
        $user = Auth::user();
        $this->canDelete = $user->hasRole('admin');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.users-list', [
            'users' => User::with('roles')
                ->when($this->search, function($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->paginate($this->perPage)
        ]);
    }

    public function deleteUser($userId)
    {
        /** @var User */
        $currentUser = Auth::user();
        $user = User::find($userId);

        if (!$user) {
            session()->flash('error', 'Usuário não encontrado.');
            return;
        }

        if ($user->hasRole('admin') && !$currentUser->hasRole('admin')) {
            session()->flash('error', 'Você não tem permissão para excluir um administrador.');
            return;
        }

        $user->delete();
        session()->flash('success', 'Usuário excluído com sucesso!');
    }
}