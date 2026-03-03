<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = $request->user();
        if (!$user || !$user->hasPermission($permission)) {
            throw new AuthorizationException('You are not authorized to perform this action.');
        }

        return $next($request);
    }
}
