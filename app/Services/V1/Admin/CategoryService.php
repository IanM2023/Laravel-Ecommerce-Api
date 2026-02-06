<?php

namespace App\Services\V1\Admin;

use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;


class CategoryService
{

    public function fetchAllCategory(array $data)
    {
        return Category::root()
            ->filter($data)
            ->with(['childrenRecursive'])
            ->paginate($data['per_page'] ?? 15);
    }

    public function createCategory(array $data)
    {
        return DB::transaction(function () use ($data) {
            
            return Category::create($data);
            
        });
    }

    public function getByIDCategory($id)
    {
        return Category::root()
            ->where('id', $id)
            ->with('childrenRecursive')
            ->firstOrFail();
    }

    public function updateCategory(array $data, $id)
    {
        return DB::transaction(function () use ($data, $id) {

            $category = Category::findOrFail($id);
        
            $category->update([
                'name' => $data['name'],
            ]);
            $category->load('childrenRecursive');

            return  $category;
        });
    }
}
