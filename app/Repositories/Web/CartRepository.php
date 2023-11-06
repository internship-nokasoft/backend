<?php

namespace App\Repositories\Web;

use App\Models\Cart;
use App\Models\Product;



class CartRepository
{

    protected Cart $cart;

    public function __construct(Cart $cart){
        $this->cart = $cart;
    }
    public function getCartItem($user_id, $product_id, $size, $color)
    {
        return $this->cart->where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->where('size', $size)
            ->where('color', $color)
            ->first();
    }

    public function createCartItem($user_id, $product_id, $size, $color, $quantity)
    {
        return $this->cart->create([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'size' => $size,
            'color' => $color,
            'quantity' => $quantity,
        ]);
    }

    public function updateCartItemQuantity($cartItem, $quantity)
    {
        $cartItem->update(['quantity' => $cartItem->quantity + $quantity]);
    }

    public function getCartByUserId($userId)
    {
        return $this->cart->where('user_id', $userId)->get();
    }

    public function removeCartItemForUser($userId, $cartItemId)
    {
        $this->cart->where('user_id', $userId)->where('id', $cartItemId)->forceDelete();
    }

    public function removeCartItemFromSession($cartItemId)
    {
        $cart = session()->get('cart');

        if (isset($cart[$cartItemId])) {
            unset($cart[$cartItemId]);
            session()->put('cart', $cart);
        }
    }

    public function getItemForUser($userId, $cartItemId)
    {
        return $this->cart->where('user_id', $userId)->where('id', $cartItemId)->first();
    }
}