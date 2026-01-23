<?php

namespace App\Http\Requests\V1\Address;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
            'type' => 'required|integer',
            'region_code' => 'required|string',
            'region_details' => 'required|string',
            'province_code' => 'required|string',
            'province_details' => 'required|string',
            'city_munic_code' => 'required|string',
            'city_munic_details' => 'required|string',
            'brgy_code' => 'required|string',
            'brgy_details' => 'required|string',
            'detailed_address' => 'required|string',
        ];
    }
}
