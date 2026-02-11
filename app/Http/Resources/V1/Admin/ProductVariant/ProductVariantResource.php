<?php

namespace App\Http\Resources\V1\Admin\ProductVariant;

use App\Http\Resources\V1\Admin\Inventory\InventoryResource;
use App\Http\Resources\V1\Admin\Product\ProductResource;
use App\Http\Resources\V1\Admin\ProductImage\ProductImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'sku'           => $this->sku,
            'price'         => $this->price,
            'status'        => $this->status,
            'product'       => new ProductResource(
                $this->whenLoaded('product')
            ),
            'inventory'     => InventoryResource::collection(
                $this->whenLoaded('inventory')
            ),
            'primary_image' => new ProductImageResource(
                $this->whenLoaded('primaryImage')
            ),
            'all_images'    => ProductImageResource::collection(
                $this->whenLoaded('images')
            )
        ];
    }
}
