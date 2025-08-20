<?php

// Middleware для аутентификации и валидации
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Middleware для проверки JWT токена
 */
class JwtAuthentication
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'error' => 'Токен авторизации не предоставлен'
            ], 401);
        }

        try {
            // Здесь должна быть логика верификации JWT токена
            // Например, используя библиотеку tymon/jwt-auth
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'error' => 'Недействительный токен'
                ], 401);
            }

            return $next($request);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Ошибка аутентификации'
            ], 401);
        }
    }
}
