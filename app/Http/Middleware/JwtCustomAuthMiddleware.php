<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JwtCustomAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            // Intenta autenticar al usuario mediante JWT
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            // Maneja la excepción de token caducado
            return response()->json([
                'meta' => [
                    'success' => false,
                    'errors' => ['Token expired']
                ]
            ], 401);
        } catch (\Exception $e) {
            // Maneja otras excepciones JWT si es necesario
            return response()->json([
                'meta' => [
                    'success' => false,
                    'errors' => ['Token invalid']
                ]
            ], 401);
        }

        // Si la autenticación fue exitosa, continúa con la solicitud
        return $next($request);
    }
}