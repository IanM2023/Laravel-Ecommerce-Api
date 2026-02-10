<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductVariant;

class Inventory extends Model
{
    /** @use HasFactory<\Database\Factories\InventoryFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'inventories';

    protected $hidden = [
        'deleted_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'product_variant_id',
        'quantity',
    ];

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
