<?php

namespace App\Http\Resources\V1\Store;

use App\Http\Resources\V1\Admin\Category\CategoryResource;
use App\Http\Resources\V1\Admin\Inventory\InventoryResource;
use App\Http\Resources\V1\Admin\ProductVariant\ProductVariantResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'categories' => CategoryResource::collection(
                $this->whenLoaded('categories')
            ),
            'variants' => ProductVariantResource::collection(
                $this->whenLoaded('variants')
            ),
        ];
    }
}