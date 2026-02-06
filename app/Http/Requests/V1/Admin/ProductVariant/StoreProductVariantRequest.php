<?php

namespace App\Http\Requests\V1\Admin\ProductVariant;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductVariantRequest extends FormRequest
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
            'sku'        => 'required|string|max:255|unique:product_variants,sku',
            'price'      => 'required|numeric|min:0', // decimal(10,2), no negatives
            'status'     => 'required|in:0,1',         // only 0 or 1
            'product_id' => 'required|exists:products,id',
        ];
    }
    
    public function messages(): array
    {
        return [
            'product_id.required' => 'Please select a product.',
            'product_id.exists'   => 'The selected product does not exist.',
            'price.min'           => 'Price must not be negative.',
            'status.in'           => 'Status must be either active or disabled.',
        ];
    }
    
}
