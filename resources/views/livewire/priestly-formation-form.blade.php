<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Formação Sacerdotal</h2>
    
    <form wire:submit="save" class="space-y-6">
        @if (session()->has('message'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Início da Teologia</label>
                <input type="date" 
                    wire:model="theology_start" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('theology_start') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Término da Teologia</label>
                <input type="date" 
                    wire:model="theology_end" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('theology_end') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Início do Sacerdócio</label>
                <input type="date" 
                    wire:model="priesthood_start" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('priesthood_start') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Término do Sacerdócio</label>
                <input type="date" 
                    wire:model="priesthood_end" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('priesthood_end') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" 
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Salvar Formação
            </button>
        </div>
    </form>
</div>