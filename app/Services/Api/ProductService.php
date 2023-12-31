<?php

namespace App\Services\Api;

use App\Models\Category;
use App\Repositories\Api\CategoryRepository;
use App\Repositories\Api\ProductRepository;


class ProductService
{
    protected ProductRepository $productRepository;
    protected CategoryRepository $categoryRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAll();
    }

    public function createProduct(array $data)
    {

        if (isset($data['product_img'])) {
            $image = $data['product_img'];
        
            $uploadPath = public_path('upload');
            $img_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img_url = 'upload/' . $img_name;
            $fullPath = $uploadPath . '/' . $img_name;
        
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        
            $image->move($uploadPath, $img_name);
            $data['product_img'] = $img_url;
        }

        try {
            $product = $this->productRepository->create($data);
            $id = $data['category_id'];
            $this->productRepository->incrementProductCount($id);
            return $product;
        } catch (\Exception $e) {
            throw $e;
        }
    }



    public function updateProduct($product, $data)
    {
        if (isset($data['product_img'])) {
            $image = $data['product_img'];
        
            $uploadPath = public_path('upload');
            $img_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img_url = 'upload/' . $img_name;
            $fullPath = $uploadPath . '/' . $img_name;
        
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        
            $image->move($uploadPath, $img_name);
            $data['product_img'] = $img_url;
        }
        return $this->productRepository->update($product, $data);
    }

    public function getProductById($id)
    {
        return $this->productRepository->find($id);
    }

    public function deleteProduct($product)
    {
        $this->productRepository->delete($product);
    }

    public function getCategoryName($id)
    {
        return $this->categoryRepository->getCategoryName($id);
    }

    public function deleteSelectedProducts(array $productIds)
    {
        $this->productRepository->deleteSelectedProduct($productIds);
    }
}