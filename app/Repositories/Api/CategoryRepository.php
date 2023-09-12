<?php

namespace App\Repositories\Api;

use App\Models\Category;


class CategoryRepository
{
    public function all()
    {
        return Category::latest()->get();
    }

    public function find($id)
    {
        return Category::find($id);
    }

    public function create($data)
    {
        return Category::create($data);
    }

    public function update($category, $data)
    {
        $category->update($data);
        return $category;
    }

    public function delete($category)
    {
        $category->forceDelete();
    }

    public function deleteSelectedCategories(array $categoryIds)
    {
        Category::whereIn('id', $categoryIds)->forceDelete();
    }

}