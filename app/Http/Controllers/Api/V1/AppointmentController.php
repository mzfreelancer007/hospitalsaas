<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Appointments\StoreAppointmentRequest;
use App\Http\Requests\Appointments\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Services\AppointmentService;
use App\Services\AuditLogService;

class AppointmentController extends BaseApiController
{
    public function __construct(private readonly AppointmentService $appointmentService, private readonly AuditLogService $auditLogService) {}

    public function index()
    {
        $q = Appointment::query()
            ->when(request('date_from'), fn($b) => $b->where('appointment_at', '>=', request('date_from')))
            ->when(request('date_to'), fn($b) => $b->where('appointment_at', '<=', request('date_to')))
            ->when(request('doctor_id'), fn($b) => $b->where('doctor_id', request('doctor_id')))
            ->when(request('patient_id'), fn($b) => $b->where('patient_id', request('patient_id')))
            ->when(request('status'), fn($b) => $b->where('status', request('status')));

        return $this->success($q->paginate(15));
    }

    public function store(StoreAppointmentRequest $request)
    {
        $payload = $request->validated();
        $this->appointmentService->assertSlotAvailable($payload['doctor_id'], $payload['appointment_at']);
        $appointment = Appointment::create($payload);
        $this->auditLogService->log($request->user()->hospital_id,$request->user()->id,'APPOINTMENT_CREATED',Appointment::class,$appointment->id,null,$request);
        return $this->success($appointment, 201);
    }

    public function update(UpdateAppointmentRequest $request, int $id)
    {
        $appointment = Appointment::findOrFail($id);
        $payload = $request->validated();
        if (isset($payload['appointment_at'])) {
            $this->appointmentService->assertSlotAvailable($appointment->doctor_id, $payload['appointment_at'], $appointment->id);
            $this->auditLogService->log($request->user()->hospital_id,$request->user()->id,'RESCHEDULED',Appointment::class,$appointment->id,$payload,$request);
        }
        if (isset($payload['status'])) {
            $this->auditLogService->log($request->user()->hospital_id,$request->user()->id,'STATUS_CHANGED',Appointment::class,$appointment->id,['status'=>$payload['status']],$request);
        }
        $appointment->update($payload);
        return $this->success($appointment);
    }
}
