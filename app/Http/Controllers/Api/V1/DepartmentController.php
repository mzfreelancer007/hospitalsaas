<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Departments\DepartmentRequest;
use App\Models\Department;
use App\Services\AuditLogService;

class DepartmentController extends BaseApiController
{
    public function __construct(private readonly AuditLogService $auditLogService) {}
    public function index() { return $this->success(Department::paginate(15)); }
    public function store(DepartmentRequest $request) {
        $d = Department::create($request->validated());
        $this->auditLogService->log($request->user()->hospital_id,$request->user()->id,'DEPARTMENT_CREATED',Department::class,$d->id,null,$request);
        return $this->success($d,201);
    }
    public function show(int $id) { return $this->success(Department::findOrFail($id)); }
    public function update(DepartmentRequest $request, int $id) { $d=Department::findOrFail($id); $d->update($request->validated()); return $this->success($d); }
    public function destroy(int $id) { Department::findOrFail($id)->delete(); return $this->success(['deleted'=>true]); }
}
