<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
        ]);

        // Tambahkan pengalihan default di sini
        $middleware->redirectTo(
            guests: '/login',
            users: '/', // Ini akan mengarahkan user yang sudah login ke halaman Katalog
        );
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
