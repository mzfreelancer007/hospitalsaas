<?php

namespace App\Http;

use App\Http\Middleware\PermissionMiddleware;
use App\Http\Middleware\TenantContextMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middlewareAliases = [
        'tenant.context' => TenantContextMiddleware::class,
        'permission' => PermissionMiddleware::class,
    ];
}
