<?php
namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        $userId = $this->route('id');
        return [
            'name' => ['sometimes','string','max:255'],
            'email' => ['sometimes','email',"unique:users,email,{$userId}"],
            'phone' => ['nullable','string','max:20'],
            'role_ids' => ['sometimes','array'],
            'role_ids.*' => ['integer','exists:roles,id'],
        ];
    }
}
