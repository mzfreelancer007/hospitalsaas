<?php

namespace App\Http\Requests\Onboarding;

use Illuminate\Foundation\Http\FormRequest;

class CreateHospitalOnboardingRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'hospital_name' => ['required', 'string', 'max:255'],
            'hospital_code' => ['required', 'string', 'max:50', 'unique:hospitals,code'],
            'owner.name' => ['required', 'string', 'max:255'],
            'owner.email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'owner.phone' => ['nullable', 'string', 'max:20'],
            'owner.password' => ['required', 'string', 'min:8'],
        ];
    }
}
