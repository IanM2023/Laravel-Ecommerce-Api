<?php

namespace App\Http\Resources\V1\Admin\Inventory;

use App\Http\Resources\V1\Admin\ProductVariant\ProductVariantResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'quantity' => $this->quantity,
            'product_variant' => ProductVariantResource::collection(
                $this->whenLoaded('productVariant')
            )
        ];
    }
}
