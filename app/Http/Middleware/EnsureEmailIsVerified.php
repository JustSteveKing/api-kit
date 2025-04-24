<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ( ! $request->user() || ! $request->user()->hasVerifiedEmail()) {
            return new JsonResponse(
                data: [
                    'message' => 'Your email address is not verified.',
                ],
                status: Response::HTTP_CONFLICT,
            );
        }

        return $next($request);
    }
}
