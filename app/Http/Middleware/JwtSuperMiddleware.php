<?php

namespace App\Http\Middleware;

use App\Helper\JsonResponseHelper;
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
                return JsonResponseHelper::unauthorized();
            }
        } catch (\Exception $e) {
            return JsonResponseHelper::unauthorized('Unauthorized', $e->getMessage());
        }
        return $next($request);
    }
}
