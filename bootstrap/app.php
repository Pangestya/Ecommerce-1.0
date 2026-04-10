<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
        $middleware->redirectUsersTo(function () {
        $role = Auth::user()->role;

        return match($role) {
            1 => route('admin.dashboard'),      // Admin
            2 => route('pengawas.dashboard'),   // Pengawas
            3 => route('pembeli.dashboard'),    // Pembeli
            default => route('dashboard'),
        };
    });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
