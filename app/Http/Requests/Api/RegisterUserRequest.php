<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'role_id' => ['required', 'string'],
            'username' => ['required', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'role_id.required' => 'Role ID is required, cannot be empty!',
            'username.required' => 'Username is required, cannot be empty!',
            'name.required' => 'Name is required, cannot be empty!',
            'email.required' => 'Email is required, cannot be empty!',
            'password' => 'Password is required, cannot be empty!',
        ];
    }
}
