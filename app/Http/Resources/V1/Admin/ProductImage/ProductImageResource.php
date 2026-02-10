<?php

namespace App\Http\Resources\V1\Admin\ProductImage;

use App\Http\Resources\V1\Admin\Product\ProductResource;
use App\Http\Resources\V1\Admin\ProductVariant\ProductVariantResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image_paths' => $this->path,
            'is_primary' => $this->is_primary,
            'variant' =>  new ProductVariantResource($this->whenLoaded('variant')),
            'product' =>  new ProductResource($this->whenLoaded('product')),
        ];
    }
}
