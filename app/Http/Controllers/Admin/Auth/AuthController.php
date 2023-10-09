<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Services\Api\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    protected AdminService $adminService;

    public function __construct(AdminService $adminService){
        $this->adminService = $adminService;
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|max:250|unique:admins',
            'password' => 'required|min:8',
        ]);
        $response = $this->adminService->register($data);
        return response($response);
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        $response = $this->adminService->login($credentials);
        return response($response);
    }

    public function getAdmin()
    {
        $admin = Auth::guard('admin')->user();
        return response()->json(['admin' => $admin]);

    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->user()->tokens()->delete();
        return response()->json(['message' => 'Logout!']);
    }
}