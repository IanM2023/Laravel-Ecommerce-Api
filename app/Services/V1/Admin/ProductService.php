<?php

namespace App\Services\V1\Admin;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function fetchAllProduct()
    {
        return Product::with('categories')->latest()->get();
    }

    public function showById(String $id)
    {
        return Product::findOrFail($id);
    }
    
    public function storeProduct(array $data)
    {
        return DB::transaction(function () use ($data) {
   
            $product = Product::storeProduct(
                Arr::except($data, ['category_id'])
            );
           
            $product->categories()->sync($data['category_id']);

            return $product;
        });
    }

    public function updateProduct(Product $product, array $data)
    {
        return DB::transaction(function () use ($product, $data) {
   
            $product->update(
                Arr::except($data, ['category_id'])
            );
           
            $product->categories()->sync($data['category_id']);

            return $product;
        });
    }

}