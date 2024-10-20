<?php

use App\Http\Middleware\Guest;
use App\Http\Middleware\Member;
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
            'guest' => Guest::class, 
            'member' => Member::class,     
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
