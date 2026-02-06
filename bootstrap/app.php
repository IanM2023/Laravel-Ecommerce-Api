<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\CheckAccountInactiveMiddleware;
use App\Http\Middleware\TransactionMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // $middleware->use([
        //     TransactionMiddleware::class,
        // ]);

        $middleware->alias([
            'user'     => UserMiddleware::class,
            'admin'    => AdminMiddleware::class,
            'inactive' => CheckAccountInactiveMiddleware::class,
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        /* ===============================
           API GLOBAL ERROR HANDLING
        =============================== */

        $exceptions->render(function (Throwable $e, Request $request) {

            if (! $request->is('api/*')) {
                return null; // let Laravel handle web errors
            }

            $response = match (true) {

                $e instanceof AuthenticationException => [
                    'status'  => 401,
                    'message' => 'Unauthenticated',
                ],

                $e instanceof AuthorizationException => [
                    'status'  => 403,
                    'message' => 'Forbidden',
                ],

                $e instanceof ValidationException => [
                    'status'  => 422,
                    'message' => 'Validation failed',
                    'errors'  => $e->errors(),
                ],

                $e instanceof ModelNotFoundException => [
                    'status'  => 404,
                    'message' => 'Resource not found',
                ],

                $e instanceof NotFoundHttpException => [
                    'status'  => 404,
                    'message' => 'Route not found',
                ],

                $e instanceof MethodNotAllowedHttpException => [
                    'status'  => 405,
                    'message' => 'Method not allowed',
                ],

                $e instanceof HttpException => [
                    'status'  => $e->getStatusCode(),
                    'message' => $e->getMessage(),
                ],

                default => [
                    'status'  => 500,
                    'message' => 'Internal server error',
                ],
            };

            // 🔥 Log only server errors
            if ($response['status'] >= 500) {
                Log::error('API Exception', [
                    'message' => $e->getMessage(),
                    'trace'   => $e->getTraceAsString(),
                    'type'    => get_class($e),
                ]);
            }

            if ($e instanceof ValidationException) {
                return response()->json([
                    'success' => false,
                    'message' => $response['message'],
                    'data'    => $response['errors'] ?? [],
                ], $response['status']);
            }

            return response()->failed([], $response['message'], $response['status']);
        });

    })->create();
