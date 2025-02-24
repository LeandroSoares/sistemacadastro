<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-lg font-semibold text-gray-800">Informações Religiosas</h2>
    <form wire:submit="save" class="space-y-6">
        @if (session()->has('message'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Data de início na Umbanda</label>
                <input type="date" wire:model="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('start_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Local de início</label>
                <input type="text" wire:model="start_location" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('start_location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Início na Casa de Caridade</label>
                <input type="date" wire:model="charity_house_start" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('charity_house_start') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Término na Casa de Caridade</label>
                <input type="date" wire:model="charity_house_end" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('charity_house_end') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Observações</label>
                <textarea wire:model="charity_house_observations" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                @error('charity_house_observations') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Início do Desenvolvimento</label>
                <input type="date" wire:model="development_start" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('development_start') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Término do Desenvolvimento</label>
                <input type="date" wire:model="development_end" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('development_end') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Início do Atendimento</label>
                <input type="date" wire:model="service_start" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('service_start') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Batismo na Umbanda</label>
                <input type="date" wire:model="umbanda_baptism" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('umbanda_baptism') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Experiência como Cambone</label>
                <div class="mt-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" wire:model="cambone_experience" class="rounded border-gray-300 text-indigo-600 shadow-sm">
                        <span class="ml-2">Sim</span>
                    </label>
                </div>
            </div>

            <div x-show="$wire.cambone_experience">
                <label class="block text-sm font-medium text-gray-700">Data de Início como Cambone</label>
                <input type="date" wire:model="cambone_start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('cambone_start_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div x-show="$wire.cambone_experience">
                <label class="block text-sm font-medium text-gray-700">Data de Término como Cambone</label>
                <input type="date" wire:model="cambone_end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('cambone_end_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Salvar Informações
            </button>
        </div>
    </form>
</div>
