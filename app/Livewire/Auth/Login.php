<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Services\ApiService;
use Illuminate\Support\Facades\Session;

class Login extends Component
{
    public $email;
    public $password;
    public $errorMessage;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login(ApiService $apiService)
    {
        // Validar los datos del formulario
        $this->validate();

        // Enviar la solicitud de login a la API
        $response = $apiService->login($this->email, $this->password);

        if (isset($response['token'])) {

            // Guardar el token en la sesión
            Session::put('auth_token', $response['token']);

            // Redirigir al dashboard del frontend
            return redirect()->route('dashboard');

        } else {
            // Si hay un error, mostrar el mensaje en el frontend
            $this->errorMessage = $response['message'] ?? 'Error al iniciar sesión';
        }
    }


    public function render()
    {
        return view('livewire.auth.login');
    }
}
