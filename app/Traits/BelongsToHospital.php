<?php

namespace App\Traits;

use App\Services\TenantContext;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToHospital
{
    public static function bootBelongsToHospital(): void
    {
        static::addGlobalScope('hospital', function (Builder $builder): void {
            $hospitalId = app(TenantContext::class)->hospitalId();
            if ($hospitalId) {
                $builder->where($builder->qualifyColumn('hospital_id'), $hospitalId);
            }
        });

        static::creating(function ($model): void {
            if (!$model->hospital_id) {
                $model->hospital_id = app(TenantContext::class)->hospitalId();
            }
        });
    }
}
