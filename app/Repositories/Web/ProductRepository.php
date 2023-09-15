<?php

namespace App\Repositories\Web;

use App\Models\Product;

class ProductRepository
{


    public function findProductById($id)
    {
        $product = Product::findOrFail($id);
        $product->size = explode(',', $product->size);
        $product->color = explode(',', $product->color);

        return $product;
    }

    public function searchProduct($keyword)
    {
        $products = Product::when($keyword, function ($query) use ($keyword) {
            return $query->where('product_name', 'like', '%' . $keyword . '%');
        })->paginate(12);

        foreach ($products as $product) {
            $product->size = explode(',', $product->size);
            $product->color = explode(',', $product->color);
        }

        return $products;
    }

    public function getProductsByCategory($id)
    {
        $products = Product::where('category_id', $id)->latest()->paginate(12);
        foreach ($products as $product) {
            $product->size = explode(',', $product->size);
            $product->color = explode(',', $product->color);
        }

        return $products;
    }

    public function getProductsByColor($color)
    {
        $products = Product::where('color', 'like', "%{$color}%")->latest()->paginate(12);
        foreach ($products as $product) {
            $product->size = explode(',', $product->size);
            $product->color = explode(',', $product->color);
        }

        return $products;
    }

    public function getProductsBySize($size)
    {
        $products = Product::where('size', 'like', "%{$size}%")->latest()->paginate(12);
        foreach ($products as $product) {
            $product->size = explode(',', $product->size);
            $product->color = explode(',', $product->color);
        }

        return $products;
    }
}