<?php

namespace App\Http\Requests\Api;

use App\Enums\CakeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CakeRequest extends FormRequest
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
            'description' => ['required', 'string'],
            'weight' => ['required', 'decimal:2'],
            'price' => ['required', 'decimal:2'],
            'stock' => ['required', 'numeric'],
            'status' => ['required', new Enum(CakeStatus::class)],
        ];
    }

    /**
     * Get an error message for the defined validation rules.
     */
    public function messages(): array {
        return [
            'name.required' => 'Name is required, cannot be empty!',
            'description.required' => 'Description is required, cannot be empty!',
            'weight.required' => 'Weight is required, cannot be empty!',
            'price.required' => 'Price is required, cannot be empty!',
            'stock.required' => 'Stock is required, cannot be empty!',
            'status.required' => 'Status is required, cannot be empty!',
        ];
    }
}
