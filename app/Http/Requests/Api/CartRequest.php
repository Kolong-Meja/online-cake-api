<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
            'user_id' => ['required', 'string'],
            'cake_id' => ['required', 'string'],
            'quantity' => ['required', 'numeric']
        ];
    }

    /**
     * Get an error message for the defined validation rules.
     */
    public function messages(): array {
        return [
            'user_id.required' => 'User ID is required, cannot be empty!',
            'cake_id.required' => 'Cake ID is required, cannot be empty!',
            'quantity.required' => 'Quantity is required, cannot be empty!',
        ];
    }
}
