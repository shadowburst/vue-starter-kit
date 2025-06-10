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
        $middleware->encryptCookies(except: ['locale', 'sidebar_state']);

        $middleware->alias([
            'banner.include' => \App\Http\Middleware\IncludeBanner::class,
            'auth.include'   => \App\Http\Middleware\Auth\AuthIncludeMiddleware::class,
            'auth.owner'     => \App\Http\Middleware\Auth\AuthOwnerMiddleware::class,
            'auth.team'      => \App\Http\Middleware\Auth\AuthTeamMiddleware::class,
            'auth.no_team'   => \App\Http\Middleware\Auth\AuthNoTeamMiddleware::class,
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\HandleTeam::class,
            \App\Http\Middleware\HandleLocale::class,
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
