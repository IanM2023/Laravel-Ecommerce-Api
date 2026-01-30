<?php

namespace App\Http\Controllers\V1\API\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Category\StoreCategoryRequest;
use App\Http\Resources\V1\Admin\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::root()
            ->filter($request)
            ->with('childrenRecursive')
            ->paginate($request->per_page);
        return CategoryResource::collection($categories);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());
        return response()->success([], 'Category created successfully', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::root()
            ->where('id', $id)
            ->with('childrenRecursive')
            ->firstOrFail();
    
        return response()->success(
            new CategoryResource($category),
            'Show Categories by id successfully',
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        $request->validated();
    
        $category = Category::findOrFail($id);
    
        $category->update([
            'name' => $request->name,
        ]);
        $category->load('childrenRecursive');
        return response()->success(
            new CategoryResource($category),
            'Category updated successfully',
            200
        );
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
