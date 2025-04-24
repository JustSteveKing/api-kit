<?php

declare(strict_types=1);

use App\Exceptions\ApiExceptionRenderer;
use App\Http\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\EnsureUserHasPermission;
use App\Http\Middleware\LogApiRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;

return Application::configure(
    basePath: dirname(__DIR__),
)->withRouting(
    api: __DIR__ . '/../routes/api/routes.php',
    commands: __DIR__ . '/../routes/console/routes.php',
    health: '/up',
    apiPrefix: '',
)->withMiddleware(
    function (Middleware $middleware): void {
        $middleware->alias([
            'abilities' => CheckAbilities::class,
            'ability' => CheckForAnyAbility::class,
            'log-requests' => LogApiRequests::class,
            'verified' => EnsureEmailIsVerified::class,
            'permission' => EnsureUserHasPermission::class,
        ]);
    },
)->withExceptions(function (Exceptions $exceptions): void {
    $exceptions->render(
        using: function (Throwable $e, Request $request) {
            if ($request->expectsJson()) {
                return new ApiExceptionRenderer(
                    exception: $e,
                    request: $request,
                )->render();
            }

            return null; // Fallback to default rendering.
        },
    );
})->create();
