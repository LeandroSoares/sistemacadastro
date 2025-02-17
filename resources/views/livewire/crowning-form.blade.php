<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Coroação</h2>
    
    <form wire:submit="save" class="space-y-6">
        @if (session()->has('message'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Data de Início</label>
                <input type="date" 
                    wire:model="start_date" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('start_date') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Data Final</label>
                <input type="date" 
                    wire:model="end_date" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('end_date') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Guia que fez a coroação</label>
                <input type="text" 
                    wire:model="guide_name" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('guide_name') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Sacerdote que fez a coroação</label>
                <input type="text" 
                    wire:model="priest_name" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('priest_name') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Terreiro</label>
                <input type="text" 
                    wire:model="temple_name" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('temple_name') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" 
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Salvar Coroação
            </button>
        </div>
    </form>
</div>
