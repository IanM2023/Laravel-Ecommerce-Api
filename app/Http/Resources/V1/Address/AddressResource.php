<?php

namespace App\Http\Resources\V1\Address;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'region_details'        => $this->region_details,
            'province_details'      => $this->province_details,
            'city_munic_details'    => $this->city_munic_details,
            'brgy_details'          => $this->brgy_details,
            'detailed_address'      => $this->detailed_address,
            'is_default'            => $this->is_default
        ];
    }
}
