<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Api\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function getAllCategories()
    {
        $categories = $this->categoryService->getAllCategories();
        return response()->json(['data' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories',
        ]);

        try {
            $data = $request->only(['category_name']);
            $category = $this->categoryService->createCategory($data);
            return response()->json(['message' => 'Category created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create category'], 500);
        }
    }

    public function destroy($id)
    {
        $category = $this->categoryService->getCategoryById($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $this->categoryService->deleteCategory($category);

        return response()->json(['message' => 'Category deleted successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|unique:categories',
        ]);

        $category = $this->categoryService->getCategoryById($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $data = $request->only(['category_name']);
        $updatedCategory = $this->categoryService->updateCategory($category, $data);

        if ($updatedCategory) {
            return response()->json(['message' => 'Category updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Category update failed'], 500);
        }
    }

    public function deleteSelectedCategories($ids)
    {
        $categoryIds = explode(",", $ids);

        if (empty($categoryIds)) {
            return response()->json(['message' => 'No categories selected'], 400);
        }

        $this->categoryService->deleteSelectedCategories($categoryIds);

        return response()->json(['message' => 'Selected categories deleted successfully']);
    }
}