<?php

namespace App\Services;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class AppointmentService
{
    public function assertSlotAvailable(int $doctorId, string $appointmentAt, ?int $ignoreId = null): void
    {
        $slotMinutes = (int) config('hms.appointment_slot_minutes', 15);
        $start = Carbon::parse($appointmentAt);
        $end = $start->copy()->addMinutes($slotMinutes);

        $query = Appointment::query()
            ->where('doctor_id', $doctorId)
            ->whereIn('status', ['BOOKED', 'CHECKED_IN'])
            ->whereBetween('appointment_at', [$start, $end]);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages(['appointment_at' => 'Selected slot is already booked for this doctor.']);
        }
    }
}
