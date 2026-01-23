<?php

namespace App\Http\Resources\V1\LocationAddress;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProvinceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->address_province_id,
            'region_id' => $this->regionID($this->region_code),
            'code' => $this->province_code,
            'description' => $this->province_description,
        ];
    }
}
