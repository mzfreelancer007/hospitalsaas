<?php
namespace App\Http\Requests\Doctors;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'user_id' => ['nullable','integer','exists:users,id'],
            'department_id' => ['required','integer','exists:departments,id'],
            'name' => ['required','string','max:255'],
            'license_no' => ['nullable','string','max:100'],
            'phone' => ['nullable','string','max:20'],
            'fee' => ['nullable','numeric','min:0'],
        ];
    }
}
