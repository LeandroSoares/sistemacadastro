<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Orixás de Cabeça</h2>
    
    <form wire:submit="save" class="space-y-6">
        @if (session()->has('message'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Orixá Ancestre</label>
                <select wire:model="ancestor" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Selecione um Orixá</option>
                    @foreach($sacredOrishas as $orisha)
                        <option value="{{ $orisha->name }}">{{ $orisha->name }}</option>
                    @endforeach
                </select>
                @error('ancestor') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Orixá de Frente</label>
                <select wire:model="front" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Selecione um Orixá</option>
                    @foreach($sacredOrishas as $orisha)
                        <option value="{{ $orisha->name }}">{{ $orisha->name }}</option>
                    @endforeach
                </select>
                @error('front') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Orixá que anda junto (Frente)</label>
                <select wire:model="front_together" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Selecione um Orixá</option>
                    @foreach($sacredOrishas as $orisha)
                        <option value="{{ $orisha->name }}">{{ $orisha->name }}</option>
                    @endforeach
                </select>
                @error('front_together') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Orixá Ajuntó</label>
                <select wire:model="adjunct" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Selecione um Orixá</option>
                    @foreach($sacredOrishas as $orisha)
                        <option value="{{ $orisha->name }}">{{ $orisha->name }}</option>
                    @endforeach
                </select>
                @error('adjunct') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Orixá que anda junto (Ajuntó)</label>
                <select wire:model="adjunct_together" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Selecione um Orixá</option>
                    @foreach($sacredOrishas as $orisha)
                        <option value="{{ $orisha->name }}">{{ $orisha->name }}</option>
                    @endforeach
                </select>
                @error('adjunct_together') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Orixá lado esquerdo</label>
                <select wire:model="left_side" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Selecione um Orixá</option>
                    @foreach($sacredOrishas as $orisha)
                        <option value="{{ $orisha->name }}">{{ $orisha->name }}</option>
                    @endforeach
                </select>
                @error('left_side') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Orixá que anda junto (Lado Esquerdo)</label>
                <select wire:model="left_side_together" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Selecione um Orixá</option>
                    @foreach($sacredOrishas as $orisha)
                        <option value="{{ $orisha->name }}">{{ $orisha->name }}</option>
                    @endforeach
                </select>
                @error('left_side_together') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Orixá lado direito</label>
                <select wire:model="right_side" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Selecione um Orixá</option>
                    @foreach($sacredOrishas as $orisha)
                        <option value="{{ $orisha->name }}">{{ $orisha->name }}</option>
                    @endforeach
                </select>
                @error('right_side') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Orixá que anda junto (Lado Direito)</label>
                <select wire:model="right_side_together" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Selecione um Orixá</option>
                    @foreach($sacredOrishas as $orisha)
                        <option value="{{ $orisha->name }}">{{ $orisha->name }}</option>
                    @endforeach
                </select>
                @error('right_side_together') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Salvar Orixás
            </button>
        </div>
    </form>
</div>
