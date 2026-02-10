<?php

namespace App\Services\V1\Admin;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProductService
{
    protected AdminLoggerService $adminLogger;

    public function __construct(AdminLoggerService $adminLogger)
    {
        $this->adminLogger = $adminLogger;
    }

    public function fetchAllProduct(array $data)
    {
        return Product::with('categories')->latest()->paginate($data['per_page'] ?? 10);
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

            $this->adminLogger->log(
                'Store',
                $product,
                'Created a new product'
            );

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

            $this->adminLogger->log(
                'Update',
                $product,
                'Updated the product item'
            );

            return $product;
        });
    }

}