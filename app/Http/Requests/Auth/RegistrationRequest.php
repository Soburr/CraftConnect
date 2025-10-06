<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegistrationRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'number' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'role' => ['required', 'in:client,artisan']
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Password is required',
            'password.confirmed' => 'Password do not match',
            'password.min' => 'Password must atleast be 8 characters long',
            'password.mixedCase' => 'Password must contain both upercase and lowercase letters',
            'password.numbers' => 'Password must contain atleast one number',
        ];

    }
}
