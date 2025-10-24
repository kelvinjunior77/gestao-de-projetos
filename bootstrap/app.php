<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Inertia\Inertia;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',

    )
    ->withMiddleware(function (Middleware $middleware) {
         $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'user' => \App\Http\Middleware\UserMiddleware::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // Erros de validação — ideais para Inertia
        $exceptions->renderable(function (ValidationException $e, $request) {
            if ($request->inertia()) {
                return back()->withErrors($e->errors())->withInput();
            }
        });

        // Acesso negado (403)
        $exceptions->renderable(function (AuthorizationException $e, $request) {
            if ($request->inertia()) {
                return inertia('Errors/Forbidden', [
                    'status' => 403,
                    'message' => 'Acesso negado — você não tem permissão.'
                ])->toResponse($request)->setStatusCode(403);
            }
        });

        //Página não encontrada (404)
        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->inertia()) {
                return Inertia::render('Errors/NotFound', [
                    'status' => 404,
                    'message' => 'Página não encontrada.'
                ])->toResponse($request)->setStatusCode(404);
            }
        });
})
->create();
