<?php

namespace App\Http\Middleware;

use App\Helper\JsonResponseHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ActiveMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (is_null($user) || !$user->isValidated()) {
            return JsonResponseHelper::unauthorized('Unauthorized');
        }

        return $next($request);
    }
}
