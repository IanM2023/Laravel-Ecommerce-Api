<?php

namespace App\Http\Resources\V1\LocationAddress;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->address_region_id,
            'code' => $this->region_code,
            'description' => $this->region_description,
        ];
    }
}
