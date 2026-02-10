<?php

namespace App\Http\Requests\V1\Admin\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInventoryRequest extends FormRequest
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
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity'           => 'required|integer|min:0'
        ];
    }

    public function messages()
    {
        return [
            'product_variant_id.required' => 'Please select at least one product variant',
            'product_variant_id.exists' => 'One or more selected product variant do not exist',
        ];
    }
}
