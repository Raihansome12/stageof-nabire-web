<?php

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
            'admin'      => \App\Http\Middleware\EnsureUserIsAdmin::class,
            // Sanctum ships these classes but does not auto-register the aliases
            // in this Laravel/Sanctum combo — needed for the 'ability:' middleware
            // used on routes/api.php to actually enforce token abilities (finding #5).
            'ability'    => \Laravel\Sanctum\Http\Middleware\CheckForAnyAbility::class,
            'abilities'  => \Laravel\Sanctum\Http\Middleware\CheckAbilities::class,
        ]);

        // Baseline security headers (CSP/HSTS/X-Frame-Options/etc.) on every response.
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
