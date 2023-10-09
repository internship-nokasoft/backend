<?php

namespace App\Services\Web;

use App\Repositories\Web\CartRepository;
use App\Repositories\Web\CategoryRepository;
use App\Repositories\Web\ColorRepository;
use App\Repositories\Web\ProductRepository;
use App\Repositories\Web\SizeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ClientService
{
    protected ProductRepository $productRepository;
    protected CategoryRepository $categoryRepository;
    protected SizeRepository $sizeRepository;
    protected ColorRepository $colorRepository;
    protected CartRepository $cartRepository;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        SizeRepository $sizeRepository,
        ColorRepository $colorRepository,
        CartRepository $cartRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->sizeRepository = $sizeRepository;
        $this->colorRepository = $colorRepository;
        $this->cartRepository = $cartRepository;
    }

    //productRepository
    public function findProductById($id)
    {
        return $this->productRepository->findProductById($id);
    }

    public function getProductsByCategory($id)
    {
        return $this->productRepository->getProductsByCategory($id);
    }

    public function searchProduct($keyword)
    {
        return $this->productRepository->searchProduct($keyword);
    }

    public function getAllCategory()
    {
        return $this->categoryRepository->getAllCategory();
    }

    public function findCategoryById($id)
    {
        return $this->categoryRepository->findCategoryById($id);
    }

    public function getAllSize()
    {
        return $this->sizeRepository->getAllSize();
    }

    public function getAllColor()
    {
        return $this->colorRepository->getAllColor();
    }

    public function getProductsByColor($id)
    {
        $color = $this->colorRepository->getNameColorById($id);
        return $this->productRepository->getProductsByColor($color);
    }

    public function getProductsBySize($id)
    {
        $size = $this->sizeRepository->getNameSizeById($id);
        return $this->productRepository->getProductsBySize($size);
    }


    //CartRepository
    public function addToCartForLoggedInUser(Request $request)
    {
        $user = Auth::guard('member')->user();
        $user_id = $user->id;
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $size = $request->size;
        $color = $request->color;

        $existingCartItem = $this->cartRepository->getCartItem($user_id, $product_id, $size, $color);

        if ($existingCartItem) {
            $this->cartRepository->updateCartItemQuantity($existingCartItem, $quantity);
        } else {
            $this->cartRepository->createCartItem($user_id, $product_id, $size, $color, $quantity);
        }
    }

    public function addToSessionCart(Request $request)
    {
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $color = $request->color;
        $size = $request->size;

        $cart = session()->get('cart', []);

        $product_id = $product_id . '-' . $size . '-' . $color;

        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] += $quantity;
        } else {
            $product_info = $this->productRepository->findProduct($product_id);
            $product_name = $product_info->product_name;
            $product_slug = $product_info->slug;
            $img = $product_info->product_img;
            $price = $request->price;

            $cart[$product_id] = [
                "product_id" => $product_id,
                "name" => $product_name,
                "img" => $img,
                "quantity" => $quantity,
                "price" => $price,
                "size" => $size,
                "color" => $color,
                "slug" => $product_slug,
            ];
        }

        session()->put('cart', $cart);
    }

    public function getCartInfo()
    {
        if (Auth::guard('member')->check()) {
            $user = Auth::guard('member')->user();
            return $this->cartRepository->getCartByUserId($user->id);
        }

        return [];
    }

    public function removeCartItemFromSession($cartItemId)
    {
        $this->cartRepository->removeCartItemFromSession($cartItemId);
    }
    public function removeCartItemForUser($cartItemId)
    {
        $user = Auth::guard('member')->user();
        $user_id = $user->id;
        $this->cartRepository->removeCartItemForUser($user_id, $cartItemId);
    }

    public function getProductInfo($id)
    {
        return $this->productRepository->findProduct($id);
    }

    public function getItemForUser($cartItemId)
    {
        $user = Auth::guard('member')->user();
        $userId = $user->id;
        return $this->cartRepository->getItemForUser($userId, $cartItemId);
    }

    public function getItemForSession($cartItemId)
    {
        $cart = session()->get('cart', []);
        return $cart[$cartItemId] ?? null;
    }

    public function updateCart(Request $request)
    {
        $product_id = $request->input('product_id');
        $cart_id = $request->input('id');
        $quantity = $request->quantity;
        if (Auth::guard('member')->check()) {
            $user = Auth::guard('member')->user();
            $user_id = $user->id;
            $item = $this->cartRepository->getItemForUser($user_id, $cart_id);
            $item->update(['quantity' => $quantity]);
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$product_id])) {
                $cart[$product_id]['quantity'] = $quantity;
                session()->put('cart', $cart);
            }
        }
    }

}