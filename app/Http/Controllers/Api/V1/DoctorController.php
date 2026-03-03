<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Doctors\DoctorRequest;
use App\Models\Doctor;
use App\Services\AuditLogService;

class DoctorController extends BaseApiController
{
    public function __construct(private readonly AuditLogService $auditLogService) {}
    public function index() { return $this->success(Doctor::paginate(15)); }
    public function store(DoctorRequest $request) { $d=Doctor::create($request->validated()); $this->auditLogService->log($request->user()->hospital_id,$request->user()->id,'DOCTOR_CREATED',Doctor::class,$d->id,null,$request); return $this->success($d,201); }
    public function show(int $id) { return $this->success(Doctor::findOrFail($id)); }
    public function update(DoctorRequest $request, int $id) { $d=Doctor::findOrFail($id); $d->update($request->validated()); return $this->success($d); }
    public function destroy(int $id) { Doctor::findOrFail($id)->delete(); return $this->success(['deleted'=>true]); }
}
