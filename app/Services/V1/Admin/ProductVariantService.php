<?php

namespace App\Services\V1\Admin;

use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class ProductVariantService
{
    protected AdminLoggerService $adminLogger;

    public function __construct(AdminLoggerService $adminLogger)
    {
        $this->adminLogger = $adminLogger;
    }

    public function fetchAllProductVariant()
    {
        return ProductVariant::latest()->get();
    }

    public function storeProductVariant(array $data)
    {
        return DB::transaction(function () use ($data) {

            $productVariant = ProductVariant::storeProductVariant($data);

            $this->adminLogger->log(
                'Store',
                $productVariant,
                'Created a new product variant'
            );

            return $productVariant;
        });
    }

    public function updateProductVariant(ProductVariant $productVariant, array $data)
    {
        return DB::transaction(function () use ($productVariant, $data) {

            $productVariant->update($data);

            $this->adminLogger->log(
                'Store',
                $productVariant,
                'Updated product variant'
            );

            return $productVariant->fresh();

        });
    }

    public function deleteProductVariant(ProductVariant $productVariant)
    {
        return DB::transaction(function () use ($productVariant) {

            $this->adminLogger->log(
                'Deleted',
                $productVariant,
                'Deleted product variant'
            );

            $productVariant->delete();
        });
    }
}
