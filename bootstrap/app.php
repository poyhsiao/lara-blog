<?php

use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\TrimStrings;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;
use Psr\Log\LogLevel;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api/v1')
                ->name('api.v1.')
                ->group(base_path('routes/api/v1.php'));

            Route::middleware(['api', 'jwt', 'jwt-admin'])
                ->prefix('api/admin')
                ->name('api.admin.')
                ->group(base_path('routes/api/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('api', [
            SubstituteBindings::class,
            TrimStrings::class,
            'throttle',
            HandleCors::class,
        ]);

        $middleware->alias([
            'jwt' => App\Http\Middleware\JwtAuthMiddleware::class,
            'jwt-admin' => App\Http\Middleware\JwtAdminMiddleware::class,
            'jwt-super' => App\Http\Middleware\JwtSuperMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        /** PDOexception will be logged as critical */
        $exceptions->level(PDOException::class, LogLevel::CRITICAL);

        $exceptions->throttle(function (Throwable $e) {
            return match (true) {
                $e instanceof BroadcastException => Limit::perMinute(300),
                default => Limit::none(),
            };
        });
    })->create();
