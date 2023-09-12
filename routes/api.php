<?php

use App\Http\Controllers\Admin\Auth\authController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::post('/admin/register',[authController::class, 'register']);
Route::post('/admin/login',[AuthController::class, 'login']);
Route::post('/admin/forgot-password',[ForgotPasswordController::class, 'forgotPassword']);
Route::post('/admin/reset-password', [ForgotPasswordController::class, 'reset']);
Route::get('/admin/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');

Route::middleware(['auth:sanctum','abilities:admin'])->group(function () {
    Route::post('/admin/logout',[AuthController::class, 'logout']);
    Route::get('/admin/details',[AuthController::class, 'getAdmin']);

    //Category
    Route::get('/admin/categories',[CategoryController::class, 'getCategory']);
    Route::post('/admin/category',[CategoryController::class, 'store']);
    Route::delete('/admin/category/{id}',[CategoryController::class, 'destroy']);
    Route::put('/admin/category/{id}',[CategoryController::class, 'update']);
    Route::delete('/admin/categories/delete/{ids}',[CategoryController::class, 'deleteSelectedCategories']);
});