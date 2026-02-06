<?php

namespace App\Services\V1\Admin;

use App\Models\inventory;
use Illuminate\Support\Facades\DB;

class InventoryService
{

    public function createInventory(array $data): Inventory
    {
        return DB::transaction(function () use ($data) {
            return Inventory::create([
                'product_variant_id' => $data['product_variant_id'],
                'quantity' => $data['quantity'],
            ]);
        });
    }

}