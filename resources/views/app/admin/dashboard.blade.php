<x-admin-layout>

    <x-slot:title>
        Dashboard - ZooNet
    </x-slot>

<h1>Dashboard</h1>
<div class="welcome-message">
    @if (session()->has('user'))
        <h1>Bienvenido, {{ session('user')['name'] }}!</h1>
    @endif
</div>
</x-admin-layout>
