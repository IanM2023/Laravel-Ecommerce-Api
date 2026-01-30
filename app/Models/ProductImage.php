<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    /** @use HasFactory<\Database\Factories\ProductImageFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'product_images';

    protected $fillable = [
        'product_id',
        'variant_id',
        'path',
        'is_primary'
    ];
}
