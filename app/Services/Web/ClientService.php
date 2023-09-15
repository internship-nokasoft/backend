<?php

namespace App\Services\Web;
use App\Repositories\Web\CategoryRepository;
use App\Repositories\Web\ColorRepository;
use App\Repositories\Web\ProductRepository;
use App\Repositories\Web\SizeRepository;


class ClientService{
    protected $productRepository;
    protected $categoryRepository;
    protected $sizeRepository;
    protected $colorRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository,
                                SizeRepository $sizeRepository, ColorRepository $colorRepository){
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->sizeRepository = $sizeRepository;
        $this->colorRepository = $colorRepository;
    }

    public function findProductById($id)
    {
        return $this->productRepository->findProductById($id);
    }

    public function getProductsByCategory($id){
        return $this->productRepository->getProductsByCategory($id);
    }

    public function searchProduct($keyword){
        return $this->productRepository->searchProduct($keyword);
    }

    public function getAllCategory(){
        return $this->categoryRepository->getAllCategory();
    }

    public function findCategoryById($id){
        return $this->categoryRepository->findCategoryById($id);
    }

    public function getAllSize(){
        return $this->sizeRepository->getAllSize();
    }

    public function getAllColor(){
        return $this->colorRepository->getAllColor();
    }

    public function getProductsByColor($id){
        $color = $this->colorRepository->getNameColorById($id);
        return $this->productRepository->getProductsByColor($color);
    }

    public function getProductsBySize($id){
        $size = $this->sizeRepository->getNameSizeById($id);
        return $this->productRepository->getProductsBySize($size);
    }
}
