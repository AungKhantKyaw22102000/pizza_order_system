<?php

// use App\Http\Middleware\AuthMiddleware;

use App\Http\Middleware\AdminMiddlewareAuth;
use App\Http\Middleware\UserMiddlewareAuth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            // 'login_auth' => AuthMiddleware::class,
            'admin_auth' => AdminMiddlewareAuth::class,
            'user_auth' => UserMiddlewareAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
