<?php

namespace App\Http\Requests\V1\Admin\ProductImage;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductImageRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'paths' => 'required|array|min:1',
            'paths.*' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048', // or your allowed types
            'is_primary' => 'required|boolean'
        ];
    }
}
