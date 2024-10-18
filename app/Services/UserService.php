<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class UserService
{
    protected $client;
    protected $apiUrl;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->apiUrl = config('services.api.url'); // Define la URL base en tu config
    }

    public function getUserProfile()
    {
        $token = Session::get('auth_token'); // Asegúrate de almacenar y recuperar el token de la sesión del usuario.

        try {
            $response = $this->client->get("{$this->apiUrl}/user/profile", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            return $data['data']; // Asegúrate de manejar los datos según la estructura de tu respuesta de la API.
        } catch (\Exception $e) {
            return null;
        }
    }
}
