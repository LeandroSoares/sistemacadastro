<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $users = User::with('roles')
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(10);
            
        $user = User::find(Auth::user()->id);
        $canDelete = $user->hasRole('admin');
        return view('users.index', compact('users', 'canDelete', 'search'));
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Este método não será mais necessário pois o Livewire irá gerenciar a criação
        return redirect()->route('users.index');
    }

    public function edit(User $user): View
    {
        $roles = Role::all();
        $canEditAdmin = $user->hasRole('admin');
        return view('users.edit', compact('user', 'roles', 'canEditAdmin'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'array'
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email']
        ];

        if ($validated['password']) {
            $userData['password'] = bcrypt($validated['password']);
        }

        $user->update($userData);

        if (isset($validated['roles'])) {
            // Apenas admin pode modificar função de admin
            $roles = collect($validated['roles']);
            if (!$user->hasRole('admin')) {
                $roles = $roles->reject(function ($role) {
                    return Role::find($role)->name === 'admin';
                });
            }
            $user->syncRoles($roles);
        }

        return redirect()->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('admin') && !$user->hasRole('admin')) {
            return redirect()->route('users.index')
                ->with('error', 'Você não tem permissão para excluir um administrador.');
        }

        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'Usuário excluído com sucesso!');
    }
} 