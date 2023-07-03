<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderItemsController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
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



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home1');

Route::get('/products/{id}', [ProductController::class, 'showProduct'])->name('products.show');
Route::get('/products', [ProductController::class, 'products'])->name('products.admin');

Route::middleware('auth')->group(function () {
    Route::post('/cart/add', [ProductController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/{id}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::post('/placeOrder', [OrderItemsController::class, 'placeOrder'])->name('placeOrder');
    Route::get('/cart/count', [ProductController::class, 'getCartCount'])->name('cart.count');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/product/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{id}', [ProductController::class, 'delete'])->name('products.delete');
    Route::get('/products/{id}/edit', [ProductController::class, 'editProduct'])->name('products.edit');
    Route::post('/products/{id}/update', [ProductController::class, 'editProductStore'])->name('products.update');


    Route::get('/addCategory', [CategoryController::class, 'addCategory'])->name('category.add');
    Route::post('/addCategory', [CategoryController::class, 'addToCategory'])->name('categories.store');
    Route::delete('/categories/{id}', [CategoryController::class, 'delete'])->name('categories.delete');
});




Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/cart', [CartController::class, 'cartItems'])->name('cart.index');
Route::delete('/cart/{id}', [CartController::class, 'deleteCart'])->name('cart.destroy');





Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');






