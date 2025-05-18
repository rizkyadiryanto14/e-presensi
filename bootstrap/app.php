<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            if ($e->getStatusCode() === 400) {
                return response()->view('errors.400', [], 400);
            } elseif ($e->getStatusCode() === 401) {
                return response()->view('errors.401', [], 401);
            } elseif ($e->getStatusCode() === 403) {
                return response()->view('errors.403', [], 403);
            } elseif ($e->getStatusCode() === 404) {
                return response()->view('errors.404', [], 404);
            } elseif ($e->getStatusCode() === 405) {
                return response()->view('errors.405', [], 405);
            } elseif ($e->getStatusCode() === 419) {
                return response()->view('errors.419', [], 419);
            } elseif ($e->getStatusCode() === 429) {
                return response()->view('errors.429', [], 429);
            } elseif ($e->getStatusCode() === 500) {
                return response()->view('errors.500', [], 500);
            } elseif ($e->getStatusCode() === 503) {
                return response()->view('errors.503', [], 503);
            }
        });
    })->create();
