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
    public $exportColumns = [
        'name' => true,
        'email' => true,
        'roles' => true,
        'created_at' => true
    ];

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


    public function exportToCsv()
{
    // Verificar se pelo menos uma coluna está selecionada
    if (!$this->exportColumns['name'] && !$this->exportColumns['email'] &&
        !$this->exportColumns['roles'] && !$this->exportColumns['created_at']) {
        session()->flash('error', 'Selecione pelo menos uma coluna para exportar.');
        return;
    }

    $filename = 'usuarios_' . date('d-m-Y_His') . '.csv';

    $users = User::with('roles')
        ->when($this->search, function($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
        ->get();

    $headers = [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename=' . $filename,
        'Pragma' => 'no-cache',
        'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
        'Expires' => '0'
    ];

    $callback = function() use ($users) {
        // Adiciona BOM para garantir que Excel reconheça caracteres especiais corretamente
        $file = fopen('php://output', 'w');
        // BOM para UTF-8
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

        // Preparar cabeçalhos CSV com base nas colunas selecionadas
        $headers = [];
        if ($this->exportColumns['name']) $headers[] = 'Nome';
        if ($this->exportColumns['email']) $headers[] = 'Email';
        if ($this->exportColumns['roles']) $headers[] = 'Funções';
        if ($this->exportColumns['created_at']) $headers[] = 'Data de Cadastro';

        // Cabeçalhos CSV com separador ponto-e-vírgula
        fputcsv($file, $headers, ';');

        // Dados com formato brasileiro
        foreach ($users as $user) {
            $rowData = [];

            if ($this->exportColumns['name']) {
                $rowData[] = $user->name;
            }

            if ($this->exportColumns['email']) {
                $rowData[] = $user->email;
            }

            if ($this->exportColumns['roles']) {
                $roles = $user->roles->pluck('name')->map(function($role) {
                    // Tradução dos papéis para português
                    $translations = [
                        'admin' => 'Administrador',
                        'manager' => 'Gerente',
                        'user' => 'Usuário'
                    ];
                    return $translations[$role] ?? $role;
                })->implode(', ');
                $rowData[] = $roles;
            }

            if ($this->exportColumns['created_at']) {
                $rowData[] = $user->created_at->format('d/m/Y H:i');
            }

            fputcsv($file, $rowData, ';');
        }

        fclose($file);
    };

    return response()->streamDownload($callback, $filename, $headers);
}
}
