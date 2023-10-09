<?php

namespace App\Repositories\Web;

use App\Models\Product;

class ProductRepository
{

    protected Product $product;

    public function __construct(Product $product){
        $this->product = $product;
    }


    public function findProductById($id)
    {
        $product = $this->product::findOrFail($id);
        $product->size = explode(',', $product->size);
        $product->color = explode(',', $product->color);

        return $product;
    }

    public function findProduct($id)
    {
        return $this->product::findOrFail($id);
    }

    public function searchProduct($keyword)
    {
        $products = $this->product::when($keyword, function ($query) use ($keyword) {
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
        $products = $this->product::where('category_id', $id)->paginate(12);
        foreach ($products as $product) {
            $product->size = explode(',', $product->size);
            $product->color = explode(',', $product->color);
        }

        return $products;
    }

    public function getProductsByColor($color)
    {
        $products = $this->product::where('color', 'like', "%{$color}%")->paginate(12);
        foreach ($products as $product) {
            $product->size = explode(',', $product->size);
            $product->color = explode(',', $product->color);
        }

        return $products;
    }

    public function getProductsBySize($size)
    {
        $products = $this->product::where('size', 'like', "%{$size}%")->paginate(12);
        foreach ($products as $product) {
            $product->size = explode(',', $product->size);
            $product->color = explode(',', $product->color);
        }

        return $products;
    }
}