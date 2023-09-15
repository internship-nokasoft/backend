<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Web\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService){
        $this->clientService = $clientService;
    }

    public function index(Request $request){
        $keyword = $request->input('search');
        $category_info = $this->clientService->getAllCategory();
        $color_info = $this->clientService->getAllColor();
        $size_info = $this->clientService->getAllSize();
        $product_info = $this->clientService->searchProduct($keyword);
        return view('front.home', compact('category_info', 'color_info', 'size_info', 'product_info'));
    }

    public function byCategory($id){
        $category_info = $this->clientService->getAllCategory();
        $color_info = $this->clientService->getAllColor();
        $size_info = $this->clientService->getAllSize();
        $products = $this->clientService->getProductsByCategory($id);

        return view('front.product.byCategory', compact('category_info', 'color_info', 'size_info', 'products'));
    }

    public function byColor($id){
        $category_info = $this->clientService->getAllCategory();
        $color_info = $this->clientService->getAllColor();
        $size_info = $this->clientService->getAllSize();
        $products = $this->clientService->getProductsByColor($id);

        return view('front.product.byColor', compact('category_info', 'color_info', 'size_info', 'products'));
    }

    public function bySize($id){
        $category_info = $this->clientService->getAllCategory();
        $color_info = $this->clientService->getAllColor();
        $size_info = $this->clientService->getAllSize();
        $products = $this->clientService->getProductsBySize($id);

        return view('front.product.bySize', compact('category_info', 'color_info', 'size_info', 'products'));
    }


    public function detail($id){

        $product = $this->clientService->findProductById($id);
        return view('front.product.detail', compact('product'));
    }
}
