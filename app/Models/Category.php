<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    /* ---------------- Scopes ---------------- */

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeFilter($query, array $filters)
    {
        return $query->when(!empty($filters['name']), function ($q) use ($filters) {
            $q->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['name']}%")
                  ->orWhereHas('childrenRecursive', function ($childQuery) use ($filters) {
                      $childQuery->where('name', 'like', "%{$filters['name']}%");
                  });
            });
        });
    }
    

    public function countProduct()
    {
        return Category::root()->whereNotNull('parent_id')->count();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}
