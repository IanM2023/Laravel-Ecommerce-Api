<?php

namespace App\Services\V1\Admin;

use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;


class CategoryService
{
    protected AdminLoggerService $adminLogger;

    public function __construct(AdminLoggerService $adminLogger)
    {
        $this->adminLogger = $adminLogger;
    }

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
            
            $category = Category::create($data);

            $this->adminLogger->log(
                'Store',
                $category,
                'Create a new category'
            );

            return $category;
            
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

            
            $this->adminLogger->log(
                'Update',
                $category,
                'Updated category ' . $data['name'] 
            );

            return  $category;
        });
    }
}
