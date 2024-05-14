<?php

use App\Http\Middleware\UpdateUserActivity;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'lastSeen' => \App\Http\Middleware\UpdateLastSeen::class,
            'status'  => \App\Http\Middleware\UserStatus::class,
        ]);
    })->withMiddleware(function (Middleware $middleware) {
        $middleware->append(UpdateUserActivity::class);
   })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();