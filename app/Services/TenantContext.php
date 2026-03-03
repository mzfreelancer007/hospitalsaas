<?php

namespace App\Services;

class TenantContext
{
    private ?int $hospitalId = null;

    public function setHospitalId(?int $hospitalId): void
    {
        $this->hospitalId = $hospitalId;
    }

    public function hospitalId(): ?int
    {
        return $this->hospitalId;
    }
}
