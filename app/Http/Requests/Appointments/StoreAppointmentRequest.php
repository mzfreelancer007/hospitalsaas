<?php
namespace App\Http\Requests\Appointments;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'patient_id' => ['required','integer','exists:patients,id'],
            'doctor_id' => ['required','integer','exists:doctors,id'],
            'appointment_at' => ['required','date'],
            'notes' => ['nullable','string'],
        ];
    }
}
