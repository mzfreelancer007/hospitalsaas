<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogService
{
    public function log(int $hospitalId, ?int $userId, string $action, string $entityType, ?int $entityId = null, ?array $meta = null, ?Request $request = null): void
    {
        AuditLog::create([
            'hospital_id' => $hospitalId,
            'user_id' => $userId,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'meta' => $meta,
            'ip' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
            'created_at' => now(),
        ]);
    }
}
