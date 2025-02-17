<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Consagrações de Entidades</h2>
    
    <!-- Lista de Consagrações -->
    <div class="mt-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Consagrações Registradas</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Entidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($consecrations as $consecration)
                    <tr>
                        <td class="px-6 py-4">
                            {{ $consecration->entity }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $consecration->name ?: '-' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $consecration->date ? \Carbon\Carbon::parse($consecration->date)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button wire:click="editConsecration({{ $consecration->id }})"
                                class="text-blue-600 hover:text-blue-900">
                                Editar
                            </button>
                            <button wire:click="deleteConsecration({{ $consecration->id }})"
                                class="text-red-600 hover:text-red-900"
                                onclick="return confirm('Tem certeza que deseja excluir esta consagração?')">
                                Excluir
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <form wire:submit="save" class="space-y-6 mt-6">
        @if (session()->has('message'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Entidade</label>
                <input type="text" 
                    wire:model="entity" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('entity') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nome</label>
                <input type="text" 
                    wire:model="name" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('name') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Data</label>
                <input type="date" 
                    wire:model="date" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('date') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror
            </div>
        </div>

        <div class="flex justify-end mt-6 space-x-2">
            @if($editing)
                <button type="button"
                    wire:click="cancelEdit"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                    Cancelar
                </button>
            @endif
            <button type="submit" 
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                {{ $editing ? 'Atualizar Consagração' : 'Adicionar Consagração' }}
            </button>
        </div>
    </form>
</div>
