<?php

namespace App\Http\Controllers\V1\API\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\ProductImage\StoreProductImageRequest;
use App\Http\Requests\V1\Admin\ProductImage\UpdateProductImageRequest;
use App\Http\Resources\V1\Admin\ProductImage\ProductImageResource;
use App\Models\ProductImage;
use App\Services\V1\Admin\ProductImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{

    protected ProductImageService $productImageService;

    public function __construct(ProductImageService $productImageService)
    {
        $this->productImageService = $productImageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productImage = ProductImage::with(['variant', 'product'])->latest()->paginate($request->per_page ?? 10);

        return ProductImageResource::collection($productImage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductImageRequest $request)
    {
        $images = $this->productImageService->storeProductImage($request->validated());
        return response()->success($images, 'Image uploaded successfully', 200);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(ProductImage $productImage)
    {
        return response()->success(
            new ProductImageResource(
                $productImage->load(['variant', 'product']) // full images
            ),
            'Show product successfully',
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductImageRequest $request, ProductImage $productImage)
    {
        $productImageUpdated = $this->productImageService->updateProductImage($productImage, $request->validated());
    
        return response()->success(
            new ProductImageResource($productImageUpdated->fresh()),
            'Image updated successfully',
            200
        );
    }
    
    /**
     * Remove the specified resource from storage.
     */

    public function destroy(ProductImage $productImage)
    {
        $this->productImageService->deleteProductImage($productImage);
    
        return response()->success(
            [],
            'Image deleted successfully',
            200
        );
    }
    
}
