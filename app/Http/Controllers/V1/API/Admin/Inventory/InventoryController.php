<?php

namespace App\Http\Controllers\V1\API\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Inventory\StoreInventoryRequest;
use App\Http\Resources\V1\Admin\Inventory\InventoryResource;
use App\Models\inventory;
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
    public function index()
    {
        $inventory = Inventory::with('productVariant')->latest()->get();
        dd($inventory);
        return response()->success(
            InventoryResource::collection($inventory),
            'Inventory fetched successfully',
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInventoryRequest $request)
    {
        $inventory = $this->inventoryService->createInventory($request->validated());
            
        return response()->success(
            new InventoryResource($inventory->load('productVariant')->fresh()),
            'Inventory product created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
