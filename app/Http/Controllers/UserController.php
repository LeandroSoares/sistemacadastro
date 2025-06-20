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

    public function store()
    {
        // Método removido: criação de usuário deve ser feita via Livewire
        abort(404);
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

        if (isset($validated['password']) && $validated['password']) {
            $userData['password'] = bcrypt($validated['password']);
        }

        $user->update($userData);

        // Atualizar as funções do usuário se forem fornecidas
        if (isset($validated['roles'])) {
            $currentUser = Auth::user();
            $roles = collect($validated['roles']);

            // Garantir que apenas IDs de roles válidos sejam considerados
            $validRoles = $roles->filter(function ($roleId) {
                return Role::find($roleId) !== null;
            });

            // Verificar se o usuário atual tem permissão para modificar o papel de admin
            $adminRole = Role::findByName('admin');
            $wasAdmin = $user->hasRole('admin');
            $willBeAdmin = $validRoles->contains($adminRole->id);

            // Se não for admin e estiver tentando adicionar/remover o papel de admin
            if ($wasAdmin != $willBeAdmin && !$currentUser->hasRole('admin')) {
                // Manter o status admin anterior se o usuário atual não for admin
                if ($wasAdmin) {
                    $validRoles->push($adminRole->id);
                } else {
                    $validRoles = $validRoles->reject(function ($roleId) use ($adminRole) {
                        return $roleId == $adminRole->id;
                    });
                }
            }

            // Sempre garantir que o usuário tenha a função 'user'
            $userRole = Role::findByName('user');
            if (!$validRoles->contains($userRole->id)) {
                $validRoles->push($userRole->id);
            }

            $user->syncRoles($validRoles->toArray());
        }

        return redirect()->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {

        if ($user->hasRole('admin')) {
            return redirect()->route('users.index')
                ->with('error', 'Não é permitido excluir um administrador.');
        }

        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'Usuário excluído com sucesso!');
    }
}
