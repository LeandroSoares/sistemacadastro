<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Meus Dados
        </h2>
    </x-slot>

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