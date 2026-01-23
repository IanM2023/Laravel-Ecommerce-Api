<?php

namespace App\Http\Resources\V1\LocationAddress;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->address_city_munic_id,
            'region_id' => $this->regionID($this->region_code),
            'province_id' => $this->provinceID($this->province_code),
            'code' => $this->city_munic_code,
            'description' => $this->city_munic_description,
        ];
    }
}
