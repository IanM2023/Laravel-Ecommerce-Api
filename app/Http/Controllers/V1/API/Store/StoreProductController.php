<?php

namespace App\Http\Controllers\V1\API\Store;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Store\StoreProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->where('status', 'active')
            ->whereHas('variants', function ($query) {
                $query->where('status', 'active')
                      ->whereHas('inventory', function ($q) {
                          $q->where('quantity', '>', 0);
                      });
            })
            ->with([
                'categories',
                'variants' => function ($query) {
                    $query->where('status', 'active')
                          ->with([
                              'inventory',
                              'primaryImage'
                          ]);
                }
            ])
            ->latest()
            ->paginate($request->per_page ?? 10);
    
        return StoreProductResource::collection($products);
    }

    public function show($id)
    {
            $product = Product::storeAvailable()->findOrFail($id);

            $categoryIds = $product->categories->pluck('id');
        
            $suggested = Product::storeAvailable()
            ->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            })
            ->where('id', '!=', $product->id)
            ->with([
                'variants' => function ($query) {
                    $query->where('status', 'active')
                          ->with('primaryImage');
                }
            ])
            ->take(8)
            ->get();

        return response()->success([
            'show' => new StoreProductResource($product),
            'suggested_product' => StoreProductResource::collection($suggested)
        ],
            'Show product by id',
            200
        );
    }

    
}
