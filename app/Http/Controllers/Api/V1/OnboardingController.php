<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Onboarding\CreateHospitalOnboardingRequest;
use App\Services\HospitalOnboardingService;

class OnboardingController extends BaseApiController
{
    public function __construct(private readonly HospitalOnboardingService $service) {}

    public function store(CreateHospitalOnboardingRequest $request)
    {
        $result = $this->service->onboard($request->validated(), $request);

        return $this->success([
            'hospital' => ['id' => $result['hospital']->id, 'name' => $result['hospital']->name, 'code' => $result['hospital']->code],
            'owner_user' => ['id' => $result['owner']->id, 'email' => $result['owner']->email],
            'token' => $result['token'],
        ], 201);
    }
}
