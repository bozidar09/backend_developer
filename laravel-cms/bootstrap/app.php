<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\RedirectUser;
use App\Http\Middleware\User;
use App\Http\Middleware\Writer;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    // Middleware dodan u Web grupu middlewwarea, bit ce pozvan na svakom requestu
    // $middleware->web([
    //     'redirectUser' => RedirectUser::class,
    // ]);

    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => Admin::class, 
            'writer' => Writer::class,     
            'user' => User::class,  
            'redirectUser' => RedirectUser::class,   
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
