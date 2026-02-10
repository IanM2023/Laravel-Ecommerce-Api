<?php

namespace App\Http\Controllers\V1\API\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Inventory\StoreInventoryRequest;
use App\Http\Requests\V1\Admin\Inventory\UpdateInventoryRequest;
use App\Http\Resources\V1\Admin\Inventory\InventoryResource;
use App\Models\Inventory;
use App\Services\V1\Admin\InventoryService;
use Illuminate\Http\Request;

class InventoryController extends Controller
{

    protected InventoryService $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $inventory = Inventory::with('productVariant.primaryImage')
            ->latest()
            ->paginate($request->per_page ?? 10);
        return  InventoryResource::collection($inventory);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInventoryRequest $request)
    {
        $inventory = $this->inventoryService->createInventory(
            $request->validated()
        );
        $inventory->load('productVariant');
        return response()->success(
            new InventoryResource($inventory),
            'Inventory product created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        return response()->success(
            new InventoryResource(
                $inventory->load('productVariant.images') // full images
            ),
            'Show product successfully',
            200
        );
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventoryRequest $request, Inventory $inventory)
    {
        $inventoryData = $this->inventoryService->updateInventory(
            $inventory, 
            $request->validated()
        );
        $inventoryData->load('productVariant');
        return response()->success(
            new InventoryResource($inventoryData),
            'Inventory product updated successfully',
            201
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        $this->inventoryService->deleteInventoryItem($inventory);
        return response()->success([],'Product inventory item deleted successfully', 200);
    }
}
