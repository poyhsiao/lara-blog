<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtSuperMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = auth()->user();

            if ($user->role < 2) {
                return response()->json([
                    'status_code' => 401,
                    'data' => null,
                    'error' => [
                        'message'=> 'Unauthorized',
                    ],
                ], Response::HTTP_FORBIDDEN);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 401,
                'data' => null,
                'error' => [
                    'message' => 'Unauthorized',
                ],
            ], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
