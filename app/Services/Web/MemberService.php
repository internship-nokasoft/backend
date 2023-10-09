<?php

namespace App\Services\Web;

use App\Mail\ForgotPasswordMail;
use App\Repositories\Web\CartRepository;
use App\Repositories\Web\MemberRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MemberService
{

    protected MemberRepository $memberRepository;
    protected CartRepository $cartRepository;

    public function __construct(MemberRepository $memberRepository, CartRepository $cartRepository)
    {
        $this->memberRepository = $memberRepository;
        $this->cartRepository = $cartRepository;
    }

    public function register($data)
    {
        return $this->memberRepository->createMember($data);
    }

    public function login($credentials)
    {
        if (Auth::guard('member')->attempt($credentials)) {
            return true;
        }
        return false;
    }

    public function logout()
    {
        Auth::guard('member')->logout();
    }

    public function sendPasswordResetEmail($member)
    {
        $this->memberRepository->createOrUpdateToken($member);
        Mail::to($member->email)->send(new ForgotPasswordMail($member));
    }

    public function resetPassword($member, $password)
    {
        $this->memberRepository->resetPassword($member, $password);
    }

    public function findByToken($token)
    {
        return $this->memberRepository->findByToken($token);
    }

    public function findByEmail($email)
    {
        return $this->memberRepository->findByEmail($email);
    }

    public function saveCartToDatabase()
    {
        $user = Auth::guard('member')->user();
        $cart = session()->get('cart', []);

        foreach ($cart as $item) {
            $this->cartRepository->createCartItem($user->id, $item['product_id'], $item['size'], $item['color'], $item['quantity']);
        }

        session()->forget('cart');
    }
}