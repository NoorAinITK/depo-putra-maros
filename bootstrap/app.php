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
        // Alias middleware pembatas peran: dipakai di routes/web.php sebagai "role:admin" / "role:user"
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // Kalau user sudah login lalu membuka halaman login lagi, arahkan ke beranda sesuai perannya.
        $middleware->redirectUsersTo(fn () => auth()->user()->role === 'admin'
            ? route('admin.dashboard')
            : route('user.beranda'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
