<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\Rbac\Permission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnsureUserHasPermission
{
    /**
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @param Permission $permission
     * @return Response
     */
    public function handle(Request $request, Closure $next, Permission $permission): Response
    {
        if ( ! $request->user() || ! $request->user()->hasPermission($permission)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
