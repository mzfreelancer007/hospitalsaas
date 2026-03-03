<?php
namespace App\Http\Requests\Appointments;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'appointment_at' => ['sometimes','date'],
            'status' => ['sometimes','in:BOOKED,CHECKED_IN,COMPLETED,CANCELLED'],
            'notes' => ['nullable','string'],
        ];
    }
}
