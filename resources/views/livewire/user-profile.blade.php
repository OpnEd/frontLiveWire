<div class="bg-white p-6 rounded shadow">
    @if ($userProfile)
        <h2 class="text-xl font-bold mb-4">Perfil de Usuario</h2>
        <p><strong>Nombre:</strong> {{ $userProfile['user']['name'] }}</p>
        <p><strong>Email:</strong> {{ $userProfile['user']['email'] }}</p>
        <p><strong>Identificación:</strong> {{ $userProfile['user']['card_id'] }} ({{ $userProfile['user']['card_id_type'] }})</p>
        <p><strong>Rol(es):</strong> {{ $userProfile['role'] }}</p> <!-- Mostrar roles -->
    @else
        <p class="text-red-500">No se pudo cargar la información del perfil. Inténtalo más tarde.</p>
    @endif
</div>
