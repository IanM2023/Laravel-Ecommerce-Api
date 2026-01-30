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

    public function scopeFilter($query, $request)
    {
        return $query->when($request->filled('name'), function ($q) use ($request) {
            $q->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->name}%")
                  ->orWhereHas('childrenRecursive', function ($childQuery) use ($request) {
                      $childQuery->where('name', 'like', "%{$request->name}%");
                  });
            });
        });
    }

    public function countProduct()
    {
        return Category::root()->whereNotNull('parent_id')->count();
    }
}
