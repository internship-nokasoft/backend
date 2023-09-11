<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class authController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|max:250|unique:admins',
            'password' => 'required|min:8',
        ]);
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $admin->createToken('admin-access-token', ['admin'])->plainTextToken;
        $response = [
            'admin' => $admin,
            'token' => $token
        ];
        return response($response);
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            return response(['message' => 'Bad creds'], 401);
        }

        $token = $admin->createToken('admin-access-token', ['admin'])->plainTextToken;
        $response = ['admin' => $admin,'token' => $token];
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