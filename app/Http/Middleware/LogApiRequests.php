<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\ApiLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class LogApiRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $start = microtime(true);

        $response = $next($request);

        \Illuminate\Support\defer(fn() => ApiLog::query()->create([
            'request_id' => $request->fingerprint(),
            'method' => $request->method(),
            'url' => $request->path(),
            'status' => $response->getStatusCode(),
            'time' => (int) ((microtime(true) - $start) * 1000),
            'request' => $request->all(),
            'response' => $response->getContent(),
            'token' => $request->bearerToken(),
            'user_id' => $request->user()?->id,
        ]));

        return $response;
    }
}
