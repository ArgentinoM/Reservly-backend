<?php

use App\Exceptions\ApiException;
use App\Http\Middleware\SellerMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            "seller" => SellerMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (ApiException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->status ?? 422);
        });

        $exceptions->render(function (NotFoundHttpException $e) {
            return response()->json([
                'error' => 'Ruta no encontrada'
            ], $e->getStatusCode());
        });


        // $exceptions->render(function (\Throwable $e, $request) {
        //     return response()->json([
        //         'error' => 'Error interno del servidor'
        //     ], 500);
        // });
    })->create();
