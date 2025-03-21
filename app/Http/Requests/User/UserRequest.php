<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name' => ['required','string','min:3','max:50'],
            'email' => ['required','email', Rule::unique('users','email')->ignore($this->user?->id)],
        ];
    }

    public function validatedUserCreate(): array
    {
        $attr = $this->validated();
        $attr['password'] = Hash::make(Str::random(8));
        return $attr;
    }
}
