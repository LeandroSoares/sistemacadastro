<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Cruz de Força</h2>

    <form wire:submit="save" class="space-y-6">
        @if (session()->has('message'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Alto</label>
                <input type="text" 
                    wire:model="top" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('top') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Embaixo</label>
                <input type="text" 
                    wire:model="bottom" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('bottom') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Esquerdo</label>
                <input type="text" 
                    wire:model="left" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('left') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Direito</label>
                <input type="text" 
                    wire:model="right" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('right') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" 
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Salvar Cruz de Força
            </button>
        </div>
    </form>
</div>
