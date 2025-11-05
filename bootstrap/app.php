<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Tambahkan use ini untuk JWT
use Tymon\JWTAuth\Http\Middleware\Authenticate as JwtAuthenticate;
use Tymon\JWTAuth\Http\Middleware\RefreshToken as JwtRefresh;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        /**
         * 🔐 Di Laravel 12, middleware alias didefinisikan di sini.
         * Mirip seperti $routeMiddleware di Kernel.php (versi lama)
         */
        $middleware->alias([
            'jwt.auth' => JwtAuthenticate::class,
            'jwt.refresh' => JwtRefresh::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
