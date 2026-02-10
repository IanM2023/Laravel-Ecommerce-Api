<?php

namespace App\Http\Controllers\V1\API\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Product\StoreProductRequest;
use App\Http\Requests\V1\Admin\Product\UpdateProductRequest;
use App\Http\Resources\V1\Admin\Product\ProductResource;
use App\Models\Product;
use App\Services\V1\Admin\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return ProductResource::collection(
            $this->productService->fetchAllProduct($request->only('per_page'))
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {

        $product = $this->productService->storeProduct($request->validated());

        return response()->success(
            new ProductResource($product->load('categories')),
            'New product created successfully',
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->success(new ProductResource(
            $this->productService->showById($id)
                ->load('categories')
        ), 'Show product by ID', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product= $this->productService->updateProduct( $product, $request->validated());
        return response()->success(
            new ProductResource($product->load('categories')),
            'Product updated successfully',
            200
        );
    }
}
