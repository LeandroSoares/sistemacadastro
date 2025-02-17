<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Cruzamentos</h2>
    <!-- Lista de Cruzamentos -->
    <div class="mt-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Cruzamentos Registrados</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Entidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Propósito</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($crossings as $crossing)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($crossing->date)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $crossing->entity }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $crossing->purpose }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button wire:click="deleteCrossing({{ $crossing->id }})"
                                class="text-red-600 hover:text-red-900"
                                onclick="return confirm('Tem certeza que deseja excluir este cruzamento?')">
                                Excluir
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <form wire:submit="save" class="space-y-6">
        @if (session()->has('message'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                <label class="block text-sm font-medium text-gray-700">Data</label>
                <input type="date" 
                    wire:model="date" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('date') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Propósito</label>
                <textarea
                    wire:model="purpose" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    rows="3"></textarea>
                @error('purpose') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" 
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Adicionar Cruzamento
            </button>
        </div>
    </form>

    
</div>
