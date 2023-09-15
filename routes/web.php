<?php

use App\Http\Controllers\User\Auth\userAuthController;
use App\Http\Controllers\User\ClientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::prefix('member')->controller(userAuthController::class)->group(function () {
    Route::get('/register', 'register')->name('register.member');
    Route::post('/store', 'store')->name('store.member');
    Route::get('/login', 'login')->name('login.member');
    Route::post('/authenticate', 'authenticate')->name('authenticate.member');
    Route::get('/logout', 'logout')->name('logout.member');
    Route::get('/forgot-password', 'forgot')->name('forgot');
    Route::post('/forgot-password', 'actionForgot')->name('forgot.action');
    Route::get('/reset/{token}', 'reset')->name('reset');
    Route::post('/reset/{token}', 'PostReset')->name('reset.action');
});

Route::controller(ClientController::class)->group(function () {
    Route::get('/home', 'index')->name('home');
    Route::get('/product-detail/{id}/{slug}', 'detail')->name('detail');

    //cart
    Route::get('/cart', 'index')->name('cart');
    Route::post('/add-to-cart', 'addtoCart')->name('addtocart');
    Route::get('/remove-cart-item/{id}', 'remove')->name('removeitem');
    Route::patch('update-cart', 'update')->name('update.cart');


    Route::get('/category/{id}/{slug}', 'byCategory')->name('bycategory');
    Route::get('/color/{id}/{slug}', 'byColor')->name('bycolor');
    Route::get('/size/{id}/{slug}', 'bySize')->name('bysize');
});