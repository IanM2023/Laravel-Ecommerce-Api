<?php

namespace App\Http\Controllers\V1\API\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\ProductVariant\StoreProductVariantRequest;
use App\Http\Requests\V1\Admin\ProductVariant\UpdateProductVariantRequest;
use App\Http\Resources\V1\Admin\ProductVariant\ProductVariantResource;
use App\Models\ProductVariant;
use App\Services\V1\Admin\ProductVariantService;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    protected ProductVariantService $productVariantService;

    public function __construct(ProductVariantService $productVariantService)
    {
        $this->productVariantService = $productVariantService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->success(
            ProductVariantResource::collection(
                $this->productVariantService->fetchAllProductVariant()->load('product')),
           'New product variant added successfully',
           200
       );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductVariantRequest $request)
    {
        $data = $request->validated();

        $productVariant = $this->productVariantService->storeProductVariant($data);

        return response()->success(
             new ProductVariantResource($productVariant->load('product')),
            'New product variant added successfully',
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductVariant $productVariant)
    {
        return response()->success(
            new ProductVariantResource($productVariant),
            'Show Product variant successfully',
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductVariantRequest $request, ProductVariant $productVariant)
    {
        $data = $request->validated();

        $productVariant = $this->productVariantService->updateProductVariant($productVariant, $data);
        return response()->success(
            new ProductVariantResource($productVariant->load('product')),
           'Product variant updated successfully',
           200
       );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariant $productVariant)
    {
        $this->productVariantService->deleteProductVariant($productVariant);

        return response()->success(
            [],
            'Product variant deleted successfully',
            200
        );
    }
}
