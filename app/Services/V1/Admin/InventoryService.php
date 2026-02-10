<?php

namespace App\Services\V1\Admin;

use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    protected AdminLoggerService $adminLogger;

    public function __construct(AdminLoggerService $adminLogger)
    {
        $this->adminLogger = $adminLogger;
    }

    public function createInventory(array $data): Inventory
    {
        return DB::transaction(function () use ($data) {
       
            $inventory =  Inventory::create([
                'product_variant_id' => $data['product_variant_id'],
                'quantity' => $data['quantity'],
            ]);

            $this->adminLogger->log(
                'Store',
                $inventory,
                'Created a new inventory item'
            );

            return $inventory;
        });
    }

    public function updateInventory(Inventory $inventory, array $data)
    {
        return DB::transaction(function () use ($inventory, $data) {

            $inventory->update($data);
            
            $this->adminLogger->log(
                'Store',
                $inventory,
                'Updated inventory item'
            );

            return $inventory->fresh();
        });
    }

    public function deleteInventoryItem(Inventory $inventory)
    {
        return DB::transaction(function () use ($inventory) {

            $this->adminLogger->log(
                'Delete',
                $inventory,
                'Deleted inventory item'
            );

            return $inventory->delete();
        });
    }

}