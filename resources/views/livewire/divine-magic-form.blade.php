<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Magias Divinas</h2>
    
    <!-- Lista de Magias -->
    <div class="mt-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Magias Registradas</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Magia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Observações</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($divineMagics as $divineMagic)
                    <tr>
                        <td class="px-6 py-4">
                            {{ $divineMagic->magicType->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $divineMagic->date ? \Carbon\Carbon::parse($divineMagic->date)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $divineMagic->performed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $divineMagic->performed ? 'Realizada' : 'Pendente' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            {{ $divineMagic->observations ?: '-' }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button wire:click="editMagic({{ $divineMagic->id }})"
                                class="text-blue-600 hover:text-blue-900">
                                Editar
                            </button>
                            <button wire:click="deleteMagic({{ $divineMagic->id }})"
                                class="text-red-600 hover:text-red-900"
                                onclick="return confirm('Tem certeza que deseja excluir esta magia?')">
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Tipo de Magia</label>
                <select wire:model="magic_type_id" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    @if($editing) disabled @endif>
                    <option value="">Selecione uma magia</option>
                    @foreach($availableMagicTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('magic_type_id') 
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

            <div class="flex items-center mt-6">
                <input type="checkbox" 
                    wire:model="performed" 
                    class="rounded border-gray-300 text-blue-600 shadow-sm">
                <label class="ml-2 block text-sm text-gray-700">
                    Magia Realizada
                </label>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Observações</label>
                <textarea
                    wire:model="observations"
                    rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                @error('observations') 
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
                {{ $editing ? 'Atualizar Magia' : 'Adicionar Magia' }}
            </button>
        </div>
    </form>
</div>
