<?php

// bootstrap/app.php
// This is the Laravel 11 way — no Middleware folder needed.
// The withExceptions() callback handles the unauthenticated redirect.

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use App\Http\Middleware\EtthnicoastUserMiddleware;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
       $middleware->alias([
        'ethnicoast_user' =>EtthnicoastUserMiddleware::class,
          $middleware->validateCsrfTokens(except: [
        '/order/razorpay',
        '/order/verify',
    ])
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // ── Redirect unauthenticated users to admin.login ─────────────────────
        $exceptions->render(function (AuthenticationException $e, $request) {
            if (! $request->expectsJson()) {
                return redirect()->route('admin.login');
            }
        });

    })->create();