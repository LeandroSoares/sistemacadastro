<div>
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">
                {{ $course ? 'Editar Curso' : 'Novo Curso' }}
            </h2>

            <form wire:submit="save" class="space-y-6">
                <!-- Nome do Curso -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome do Curso</label>
                    <div class="mt-1">
                        <x-text-input
                            type="text"
                            id="name"
                            wire:model="name"
                            class="w-full"
                            placeholder="Digite o nome do curso" />
                    </div>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status do Curso -->
                <div>
                    <div class="flex items-center">
                        <input type="checkbox" name="active" id="active" wire:model="active">
                        <label for="active" class="ml-2 block text-sm text-gray-900">
                            Curso Ativo
                        </label>
                    </div>
                    @error('active')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botões -->
                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('courses.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-wider shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition">
                        Cancelar
                    </a>

                    <x-primary-button type="submit">
                        {{ $course ? 'Atualizar' : 'Criar' }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>