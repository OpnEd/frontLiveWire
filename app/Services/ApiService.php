<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Session;

class ApiService
{
    protected $client;
    protected $apiUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = config('services.api.url'); // Define la URL base en tu config
    }

    public function login($email, $password)
    {
        try {
            $response = $this->client->post("{$this->apiUrl}/login", [
                'json' => [
                    'email' => $email,
                    'password' => $password
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function register($data)
    {
        try {
            $response = $this->client->post("{$this->apiUrl}/register", [
                'json' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function logout()
    {
        $token = session('auth_token');

        try {
            $response = $this->client->post("{$this->apiUrl}/logout", [
                'headers' => [
                    'Authorization' => "Bearer {$token}"
                ]
            ]);

            // return json_decode($response->getBody()->getContents(), true);

            // Eliminar el token de la sesión si la API responde correctamente
            if ($response->getStatusCode() === 200) {
                session()->forget(['auth_token', 'user']);
                return [
                    'success' => true,
                    'message' => 'Sesión cerrada correctamente.'
                ];
            } else {
                return [
                    'error' => true,
                    'message' => 'Error al intentar cerrar sesión.'
                ];
            }
        } catch (RequestException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function getDashboard()
    {
        try {

            $token = Session::get('auth_token'); // Recuperar el token de la sesión

            $response = $this->client->get("{$this->apiUrl}/dashboard", [
                'headers' => [
                    'Authorization' => "Bearer {$token}",
                    'Accept' => 'application/json',
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {

            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
}
