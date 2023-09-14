<?php

namespace App\Repositories\Api;

use App\Models\Category;
use App\Models\Product;


class ProductRepository
{

    public function getAll()
    {
        return Product::latest()->get();
    }

    public function find($id)
    {
        return Product::find($id);
    }

    public function getCategoryName($id)
    {
        return Category::where('id', $id)->value('category_name');
    }

    public function create(array $data)
    {
        return Product::create($data);
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
        Category::where('id', $categoryId)->decrement('product_cout', 1);
    }

    public function deleteSelectedProduct(array $productIds)
    {
        $categoryIds = Product::whereIn('id', $productIds)->pluck('category_id')->toArray();
        Product::whereIn('id', $productIds)->forceDelete();
       
        $uniqueCategoryIds = array_unique($categoryIds);

        
        foreach ($uniqueCategoryIds as $categoryId) {
            $productCount = count(array_keys($categoryIds, $categoryId)); 
            Category::where('id', $categoryId)->decrement('product_cout', $productCount);
        }
    }
    
}