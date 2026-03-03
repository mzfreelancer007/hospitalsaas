<?php

namespace App\Http\Middleware;

use App\Services\TenantContext;
use Closure;
use Illuminate\Http\Request;

class TenantContextMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        app(TenantContext::class)->setHospitalId($request->user()?->hospital_id);

        return $next($request);
    }
}
