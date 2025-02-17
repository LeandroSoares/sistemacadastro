<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Cursos Religiosos de Umbanda</h2>
    <!-- Lista de Cursos -->
    <div class="mt-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Cursos Registrados</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($courses as $religiousCourse)
                    <tr>
                        <td class="px-6 py-4">
                            {{ $religiousCourse->course->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $religiousCourse->date ? \Carbon\Carbon::parse($religiousCourse->date)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $religiousCourse->finished ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $religiousCourse->finished ? 'Finalizado' : 'Em andamento' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button wire:click="deleteCourse({{ $religiousCourse->id }})"
                                class="text-red-600 hover:text-red-900"
                                onclick="return confirm('Tem certeza que deseja excluir este curso?')">
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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nome do Curso</label>
                <select wire:model="course_id" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Selecione um curso</option>
                    @foreach($availableCourses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
                @error('course_id') 
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
                    wire:model="finished" 
                    class="rounded border-gray-300 text-blue-600 shadow-sm">
                <label class="ml-2 block text-sm text-gray-700">
                    Curso Finalizado
                </label>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" 
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Adicionar Curso
            </button>
        </div>
    </form>

    
</div>
