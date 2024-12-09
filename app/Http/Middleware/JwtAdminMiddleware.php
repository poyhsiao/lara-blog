<?php

namespace App\Http\Middleware;

use App\Helper\JsonResponseHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class JwtAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = Auth::user();

            if ($user->role < 1) {
                return JsonResponseHelper::unauthorized();
            }
        } catch (\Exception $e) {
            return JsonResponseHelper::error($e->getMessage(), 'Unauthorized', HttpResponse::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
