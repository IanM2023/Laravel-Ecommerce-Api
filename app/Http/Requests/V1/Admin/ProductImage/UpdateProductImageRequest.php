<?php

namespace App\Http\Requests\V1\Admin\ProductImage;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'paths' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
            'is_primary' => 'required|boolean',
        ];
    }
}

