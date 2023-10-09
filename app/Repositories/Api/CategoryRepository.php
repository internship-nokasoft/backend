<?php

namespace App\Repositories\Api;

use App\Models\Category;


class CategoryRepository
{

    protected Category $category;

    public function __construct(Category $category){
        $this->category = $category; 
    }

    public function all()
    {
        return $this->category::latest()->get();
    }

    public function find($id)
    {
        return $this->category::find($id);
    }

    public function create($data)
    {
        return $this->category::create($data);
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
        $this->category::whereIn('id', $categoryIds)->forceDelete();
    }

    public function getCategoryName($id)
    {
        return $this->category::where('id', $id)->value('category_name');
    }

}