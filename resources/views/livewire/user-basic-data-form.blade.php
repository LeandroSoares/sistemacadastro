<div class="w-full">
    <form wire:submit="save" class="p-6">
        @if (!$isCreating)
            <h2 class="text-lg font-medium text-gray-900 mb-6">
                Editar Dados Básicos do Usuário
            </h2>
        @endif

        @if (session('success'))
            <div class="mb-6 p-4 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="name" value="Nome" />
                <x-text-input id="name" wire:model="name" type="text" class="mt-1 block w-full" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" wire:model="email" type="email" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="password" value="{{ $isCreating ? 'Senha' : 'Nova Senha (opcional)' }}" />
                <x-text-input id="password" wire:model="password" type="password" class="mt-1 block w-full" :required="$isCreating" />
                <x-input-error class="mt-2" :messages="$errors->get('password')" />
            </div>

            <div>
                <x-input-label for="password_confirmation" value="Confirmar Senha" />
                <x-text-input id="password_confirmation" wire:model="password_confirmation" type="password" class="mt-1 block w-full" :required="$isCreating" />
                <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
            </div>
        </div>

        <div class="mt-6">
            <x-input-label for="roles" value="Funções" />
            <div class="mt-2 space-y-2">
                <!-- Role 'user' fixa -->
                <div class="flex items-center bg-gray-50 p-2 rounded">
                    <input type="checkbox" checked disabled
                        class="rounded border-gray-300 text-gray-600 shadow-sm focus:ring-gray-500 cursor-not-allowed">
                    <label class="ml-2 text-sm text-gray-600">{{ __('user') }} (Padrão)</label>
                </div>
                
                <!-- Outras roles -->
                <div class="mt-2 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach($roles as $role)
                        <div class="flex items-center">
                            <input type="checkbox" wire:model="selectedRoles" value="{{ $role->id }}" id="role_{{ $role->id }}"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <label for="role_{{ $role->id }}" class="ml-2 text-sm text-gray-600">{{ __($role->name) }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('selectedRoles')" />
        </div>

        <div class="mt-6 flex justify-end">
            @if ($isCreating)
                <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Cancelar
                </a>
            @else
                <x-secondary-button type="button" @click="$dispatch('close-modal', { name: 'edit-user-basic' })">
                    Cancelar
                </x-secondary-button>
            @endif

            <x-primary-button class="ml-3">
                {{ $isCreating ? 'Criar Usuário' : 'Salvar Alterações' }}
            </x-primary-button>
        </div>
    </form>
</div> 