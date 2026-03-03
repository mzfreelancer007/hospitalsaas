<?php
namespace App\Http\Requests\Patients;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return (new StorePatientRequest())->rules(); }
}
