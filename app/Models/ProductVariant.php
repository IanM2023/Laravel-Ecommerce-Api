<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Inventory;

class ProductVariant extends Model
{
    /** @use HasFactory<\Database\Factories\ProductVariantFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'product_variants';

    protected $hidden = [
        'deleted_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'status'
    ];

    public static function storeProductVariant(array $data)
    {
        return self::create([
            'product_id'        => $data['product_id'],
            'sku'               => $data['sku'],
            'price'             => $data['price'],
            'status'            => $data['status'],
        ]);
    }

    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'variant_id')->latest();
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class, 'variant_id')->where('is_primary', 1);
    }
}
