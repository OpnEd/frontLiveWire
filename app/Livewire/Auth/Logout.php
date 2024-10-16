<?php

namespace App\Livewire\Auth;

use App\Services\ApiService;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Logout extends Component
{

    public function logout(ApiService $apiService)
    {
        $token = session('auth_token');

        // Realizar la solicitud de logout a la API
        $response = $apiService->logout($token);

        if (isset($response['message'])) {

            // Limpiar la sesión local
            Session::forget(['auth_token', 'user']);

            // Redirigir al usuario al login después de cerrar la sesión correctamente
            return redirect()->route('login')->with('message', 'Sesión cerrada correctamente.');
        } else {
            // Manejar errores si el logout no fue exitoso
            session()->flash('error', $response['message'] ?? 'Error al intentar cerrar sesión.');
        }
    }
    public function render()
    {
        return view('livewire.auth.logout');
    }
}
