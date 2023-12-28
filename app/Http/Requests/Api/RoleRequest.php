<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

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
            'title' => ['required', 'string', 'max:255'],
            'abilities' => ['required', 'string']
        ];
    }

     /**
     * Get an error message for the defined validation rules.
     */
    public function messages(): array {
        return [
            'title.required' => 'Role title is required, cannot be empty!',
            'abilities.required' => 'Abilities is required, cannot be empty!',
        ];
    }
}
