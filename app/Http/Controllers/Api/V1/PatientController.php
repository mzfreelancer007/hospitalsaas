<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Patients\StorePatientRequest;
use App\Http\Requests\Patients\UpdatePatientRequest;
use App\Models\Patient;
use App\Services\AuditLogService;
use App\Services\PatientCodeService;

class PatientController extends BaseApiController
{
    public function __construct(private readonly PatientCodeService $codeService, private readonly AuditLogService $auditLogService) {}

    public function index()
    {
        $q = Patient::query()->when(request('search'), fn ($b) => $b->where('name', 'like', '%'.request('search').'%')->orWhere('phone', 'like', '%'.request('search').'%'));
        return $this->success($q->paginate(15));
    }

    public function store(StorePatientRequest $request)
    {
        $data = $request->validated();
        $data['patient_code'] = $this->codeService->nextCode($request->user()->hospital_id);
        $patient = Patient::create($data);
        $this->auditLogService->log($request->user()->hospital_id, $request->user()->id, 'PATIENT_CREATED', Patient::class, $patient->id, null, $request);
        return $this->success($patient, 201);
    }

    public function show(int $id) { return $this->success(Patient::query()->findOrFail($id)); }

    public function update(UpdatePatientRequest $request, int $id)
    {
        $patient = Patient::query()->findOrFail($id);
        $patient->update($request->validated());
        $this->auditLogService->log($request->user()->hospital_id, $request->user()->id, 'PATIENT_UPDATED', Patient::class, $patient->id, null, $request);
        return $this->success($patient);
    }
}
