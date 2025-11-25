<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'No autenticado'
            ], 401);
        }

        if ($user->rol_id !== 1) {
            return response()->json([
                'message' => 'No tienes permisos para acceder a esta ruta'
            ], 403);
        }

        return $next($request);
    }
}
