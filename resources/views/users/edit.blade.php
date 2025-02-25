<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editando dados de: {{ $user->name }}
            </h2>
            <x-primary-button x-data="" @click="$dispatch('open-modal', { name: 'edit-user-basic' })">
                Editar dados de login
            </x-primary-button>
        </div>
    </x-slot>

    <div x-data="{ showModal: false }" 
         @open-modal.window="if ($event.detail.name === 'edit-user-basic') showModal = true"
         @close-modal.window="if ($event.detail.name === 'edit-user-basic') showModal = false">
        
        <div x-show="showModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div x-show="showModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all w-full sm:my-8 sm:max-w-4xl mx-auto">
                    <div class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block">
                        <button type="button" @click="showModal = false" class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <span class="sr-only">Fechar</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="sm:flex sm:items-start w-full">
                        <livewire:user-basic-data-form :user="$user" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:personal-data-form :user="$user" />
            <br>
            <livewire:religious-info-form :user="$user" />
            <br>
            <livewire:priestly-formation-form :user="$user" />
            <br>
            <livewire:crowning-form :user="$user" />
            <br>
            <livewire:head-orisha-form :user="$user" />
            <br>
            <livewire:force-cross-form :user="$user" />
            <br>
            <livewire:crossing-form :user="$user" />
            <br>
            <livewire:work-guide-form :user="$user" />
            <br>
            <livewire:religious-course-form :user="$user" />
            <br>
            <livewire:initiated-mystery-form :user="$user" />
            <br>
            <livewire:initiated-orisha-form :user="$user" />
            <br>
            <livewire:divine-magic-form :user="$user" />
            <br>
            <livewire:entity-consecration-form :user="$user" />
            <br>
            <livewire:amaci-form :user="$user" />
            <br>
            <livewire:last-temple-form :user="$user" />
        </div>
    </div>
</x-app-layout>