<?php

namespace App\Http\Resources\V1\LocationAddress;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaranggayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->address_brgy_id,
            'region_id' => $this->regionID($this->region_code),
            'province_id' => $this->provinceID($this->province_code),
            'city_id' => $this->cityID($this->city_munic_code),
            'code' => $this->brgy_code,
            'description' => $this->brgy_description,
        ];
    }
}
