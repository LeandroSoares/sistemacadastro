<x-app-layout>
    <h1>Manage Users</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <livewire:user-management />
</x-app-layout>