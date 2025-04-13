<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','min:3','max:50',Rule::unique('roles','name')->ignore($this->role?->id)],
            'permissions_id' => ['required','array'],
            'permissions_id.*' => ['numeric','gt:0','exists:permissions,id'],
        ];
    }
    public function validatedRole(): array
    {
        return $this->only('name');
    }
    public function validatedPermissionsIds(): array
    {
        return $this->only('permissions_id')['permissions_id'];
    }
}
