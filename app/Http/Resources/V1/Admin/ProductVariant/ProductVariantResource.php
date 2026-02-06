<?php

namespace App\Http\Resources\V1\Admin\ProductVariant;

use App\Http\Resources\V1\Admin\Product\ProductResource;
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
            'id' => $this->id,
            'sku' => $this->sku,
            'price' => $this->price,
            'status' => $this->status,
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
