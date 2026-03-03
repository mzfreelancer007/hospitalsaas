<?php

namespace App\Services;

use App\Models\Hospital;
use App\Models\HospitalCounter;
use Illuminate\Support\Facades\DB;

class PatientCodeService
{
    public function nextCode(int $hospitalId): string
    {
        return DB::transaction(function () use ($hospitalId): string {
            $counter = HospitalCounter::query()->lockForUpdate()->firstOrCreate(
                ['hospital_id' => $hospitalId, 'key' => 'patient'],
                ['current_value' => 0]
            );
            $counter->increment('current_value');
            $hospitalCode = Hospital::query()->findOrFail($hospitalId)->code;

            return sprintf('%s-%06d', $hospitalCode, $counter->current_value);
        });
    }
}
