<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;

use App\Services\Web\MemberService;
use Illuminate\Http\Request;


class UserAuthController extends Controller
{

    protected MemberService $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }
    public function register()
    {
        return view('front.auth.register');
    }

    public function login()
    {
        return view('front.auth.login');
    }

    public function forgot()
    {
        return view('front.auth.forgot-password');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:members',
            'password' => 'required|min:8'
        ]);

        $this->memberService->register($data);

        $credentials = $request->only('email', 'password');
        $this->memberService->login($credentials);
        $request->session()->regenerate();
        $this->memberService->saveCartToDatabase();
        return redirect()->route('login.member');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($this->memberService->login($credentials)) {
            $request->session()->regenerate();
            $this->memberService->saveCartToDatabase();
            return redirect()->route('home')
                ->with('message', 'Đăng nhập thành công!');
        }

        return back()->with('message', 'Nhập sai thông tin!');
    }

    public function logout(Request $request)
    {
        $this->memberService->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function actionForgot(Request $request)
    {

        $member = $this->memberService->findByEmail($request->email);
        if (!empty($member)) {
            $this->memberService->sendPasswordResetEmail($member);
            return back()->with('message', 'Please check your email and reset your password!');
        } else {
            return back()->with('message', 'Email not found!');
        }

    }

    public function reset($token)
    {
        $member = $this->memberService->findByToken($token);
        return view('front.auth.reset-password', compact('member'));
    }


    public function PostReset(Request $request, $token)
    {
        $member = $this->memberService->findByToken($token);
        $this->memberService->resetPassword($member, $request->password);

        return redirect()->route('login.member');
    }
}