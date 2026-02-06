<?php

namespace App\Http\Resources\V1\Admin\Category;

use App\Http\Resources\V1\Admin\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {

        return [
            'id'                => $this->id,
            'category_name'     => $this->name,
            'total_product'     => $this->countProduct(),
            'children' => CategoryResource::collection(
                $this->whenLoaded('childrenRecursive')
            ),
            'products' => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
