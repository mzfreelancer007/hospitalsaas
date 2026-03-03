<?php
namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'email' => ['required','email','unique:users,email'],
            'phone' => ['nullable','string','max:20'],
            'password' => ['required','string','min:8'],
            'role_ids' => ['required','array'],
            'role_ids.*' => ['integer','exists:roles,id'],
        ];
    }
}
