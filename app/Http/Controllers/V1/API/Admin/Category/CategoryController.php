<?php

namespace App\Http\Controllers\V1\API\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Category\StoreCategoryRequest;
use App\Http\Resources\V1\Admin\Category\CategoryResource;
use App\Models\Category;
use App\Services\V1\Admin\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;
    

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return CategoryResource::collection($this->categoryService->fetchAllCategory($request->all()));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->createCategory(
            $request->validated()
        );
    
        return response()->success(
            new CategoryResource($category),
            'Category created successfully',
            201
        );
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->success(
            new CategoryResource($this->categoryService->getByIDCategory($id)),
            'Show Categories by id successfully',
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        $category = $this->categoryService->updateCategory($request->validated(), $id); 
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
