<?php
namespace App\Http\Requests\Patients;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'dob' => ['nullable','date'],
            'gender' => ['nullable','string','max:20'],
            'phone' => ['nullable','string','max:20'],
            'address' => ['nullable','string'],
            'emergency_contact' => ['nullable','string','max:255'],
        ];
    }
}
