<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $timestamps = false;
    const UPDATED_AT = null;

    protected $fillable = [
        'hospital_id', 'user_id', 'action', 'entity_type', 'entity_id', 'meta', 'ip', 'user_agent', 'created_at',
    ];

    protected $casts = ['meta' => 'array', 'created_at' => 'datetime'];
}
