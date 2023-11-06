<?php

namespace App\Repositories\Api;

use App\Models\Category;
use App\Models\Product;


class ProductRepository
{

    protected Product $product ;
    protected Category $category;

    public function __construct(Product $product, Category $category){
        $this->product = $product;
        $this->category = $category;
    }
    public function getAll()
    {
        return $this->product->latest()->get();
    }

    public function find($id)
    {
        return $this->product->find($id);
    }

    public function create(array $data)
    {
        return $this->product->create($data);
    }

    public function update($product, $data)
    {
        $product->update($data);
        return $product;
    }

    public function delete($product)
    {
        $categoryId = $product->category_id;
        $product->forceDelete();
        $this->category->where('id', $categoryId)->decrement('product_cout', 1);
    }

    public function deleteSelectedProduct(array $productIds)
    {
        $categoryIds = $this->product->whereIn('id', $productIds)->pluck('category_id')->toArray();
        $this->product->whereIn('id', $productIds)->forceDelete();

        $uniqueCategoryIds = array_unique($categoryIds);


        foreach ($uniqueCategoryIds as $categoryId) {
            $productCount = count(array_keys($categoryIds, $categoryId));
            Category::where('id', $categoryId)->decrement('product_cout', $productCount);
        }
    }

    public function incrementProductCount($id)
    {
        Category::where('id', $id)->increment('product_cout', 1);
    }

}