<?php

namespace App\Http\Resources\V1\Admin\Inventory;

use App\Http\Resources\V1\Admin\ProductImage\ProductImageResource;
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
            'updated_at' => $this->updated_at->format('Y:d:m h:i:s a'),
            'product_variant' => new ProductVariantResource(
                $this->whenLoaded('productVariant')
            ),
            'product_primary_image' => $this->when($this->relationLoaded('productVariant') &&
                $this->productVariant->relationLoaded('primaryImage'), 
           new ProductImageResource($this->whenLoaded('productVariant.primaryImage')? $this->productVariant->primaryImage : collect())
            ),
            'all_product_image' => $this->when($this->relationLoaded('productVariant') &&
                $this->productVariant->relationLoaded('images'),
            ProductImageResource::collection($this->whenLoaded('productVariant.images') ? $this->productVariant->images : collect())
            )
        ];
    }
}
