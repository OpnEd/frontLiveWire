<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TokenAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el token existe en la sesión
        if (!session()->has('auth_token')) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder.');
        }

        $token = session('auth_token');
        $client = new Client();
        $apiUrl = config('services.api.url');

        try {
            // Verificar si el token es válido haciendo una petición a la API
            $response = $client->request('GET', "{$apiUrl}/user", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                // Decodificar la respuesta para obtener los datos del usuario
                $userData = json_decode($response->getBody(), true);

                // Verificar que la respuesta contenga los datos esperados
                if (isset($userData['success']) && $userData['success']) {
                    // Guardar los datos del usuario en la sesión
                    session()->put('user', $userData['data']);

                    // Proceder con la solicitud
                    return $next($request);
                } else {
                    // Si la respuesta no tiene los datos esperados, eliminar el token
                    session()->forget(['auth_token', 'user']);
                    return redirect()->route('login')->with('error', 'Sesión expirada. Inicia sesión nuevamente.');
                }
            } else {
                // Si el código de respuesta no es 200, limpiar la sesión y redirigir al login
                session()->forget(['auth_token', 'user']);
                return redirect()->route('login')->with('error', 'Sesión expirada. Inicia sesión nuevamente.');
            }
        } catch (RequestException $e) {
            // Manejar excepciones en la solicitud (problemas de red, token inválido, etc.)
            session()->forget(['auth_token', 'user']);
            return redirect()->route('login')->with('error', 'Error de autenticación. Por favor, inicia sesión.');
        }
    }
}
