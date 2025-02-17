<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Guias de Trabalho</h2>
    
    <form wire:submit="save" class="space-y-6">
        @if (session()->has('message'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Caboclos -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Caboclo</label>
                <input type="text" 
                    wire:model="caboclo" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Cabocla</label>
                <input type="text" 
                    wire:model="cabocla" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <!-- Orixás -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Ogum</label>
                <input type="text" 
                    wire:model="ogum" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Xangô</label>
                <input type="text" 
                    wire:model="xango" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <!-- Baianos -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Baiano</label>
                <input type="text" 
                    wire:model="baiano" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Baiana</label>
                <input type="text" 
                    wire:model="baiana" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <!-- Pretos Velhos -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Preto Velho</label>
                <input type="text" 
                    wire:model="preto_velho" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Preta Velha</label>
                <input type="text" 
                    wire:model="preta_velha" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <!-- Boiadeiros -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Boiadeiro</label>
                <input type="text" 
                    wire:model="boiadeiro" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Boiadeira</label>
                <input type="text" 
                    wire:model="boiadeira" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <!-- Ciganos -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Cigano</label>
                <input type="text" 
                    wire:model="cigano" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Cigana</label>
                <input type="text" 
                    wire:model="cigana" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <!-- Outros -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Marinheiro</label>
                <input type="text" 
                    wire:model="marinheiro" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Erê</label>
                <input type="text" 
                    wire:model="ere" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <!-- Exus -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Exu</label>
                <input type="text" 
                    wire:model="exu" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Pombagira</label>
                <input type="text" 
                    wire:model="pombagira" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Exu Mirim</label>
                <input type="text" 
                    wire:model="exu_mirim" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" 
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Salvar Guias
            </button>
        </div>
    </form>
</div>
