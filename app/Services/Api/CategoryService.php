<?php

namespace App\Services\Api;

use App\Repositories\Api\CategoryRepository;

class CategoryService
{

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->all();
    }

    public function createCategory($data)
    {
        return $this->categoryRepository->create($data);
    }

    public function updateCategory($category, $data)
    {
        return $this->categoryRepository->update($category, $data);
    }

    public function getCategoryById($id){
        return $this->categoryRepository->find($id);
    }

    public function deleteCategory($category)
    {
        $this->categoryRepository->delete($category);
    }

    public function deleteSelectedCategories(array $categoryIds)
    {
        $this->categoryRepository->deleteSelectedCategories($categoryIds);
    }

    
}