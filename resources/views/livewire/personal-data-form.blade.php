<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-lg font-semibold text-gray-800">Dados Pessoais</h2>
    <form wire:submit="save" class="space-y-6">
        @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
            {{ session('message') }}
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nome</label>
                <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Endereço</label>
                <input type="text" wire:model="address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">CEP</label>
                <input type="text" x-mask="99999-999" wire:model="zip_code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('zip_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" wire:model="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">CPF</label>
                <input type="text" x-mask="999.999.999-99" wire:model="cpf" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('cpf') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">RG</label>
                <div class="flex flex-col space-y-2">
                    <input
                        type="text"
                        x-mask:dynamic="rgMask"

                        wire:model="rg"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        placeholder="Digite o RG com ou sem pontuação">
                </div>
                @error('rg') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
                <input type="date" wire:model="birth_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('birth_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Telefone Fixo</label>
                <input type="text" wire:model="home_phone" x-mask:dynamic="telMask" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Celular</label>
                <input type="text" wire:model="mobile_phone" x-mask:dynamic="telMask" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('mobile_phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Telefone Trabalho</label>
                <input type="text" wire:model="work_phone" x-mask:dynamic="telMask" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Contato de Emergência</label>
                <input type="text" wire:model="emergency_contact" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('emergency_contact') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Salvar Dados
            </button>
        </div>
    </form>
</div>
