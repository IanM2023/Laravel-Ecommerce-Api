<?php

namespace App\Services\V1\Admin;

use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class ProductVariantService
{
    public function fetchAllProductVariant()
    {
        return ProductVariant::latest()->get();
    }

    public function storeProductVariant(array $data)
    {
        return DB::transaction(function () use ($data) {

            $productVariant = ProductVariant::storeProductVariant($data);

            return $productVariant;
        });
    }

    public function updateProductVariant(ProductVariant $productVariant, array $data)
    {
        return DB::transaction(function () use ($productVariant, $data) {

            $productVariant->update($data);

            return $productVariant->fresh();

        });
    }

    public function deleteProductVariant(ProductVariant $productVariant)
    {
        return DB::transaction(function () use ($productVariant) {
            $productVariant->delete();
        });
    }
}
