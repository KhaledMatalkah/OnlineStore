<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller

{
    protected $cartRepository;
    protected $productRepository;

    public function __construct(CartRepositoryInterface $cartRepository, ProductRepositoryInterface $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }
    public function create()
    {
        $categories = $this->productRepository->create();
        $cartItemCount = $this->cartRepository->getCartItemCountByUserId(auth()->id());
        return view('admin.productCreate', compact('cartItemCount', 'categories'));
    }

    public function store(Request $request)
    {
        $result = $this->productRepository->store($request);
        if($result == true){
            return redirect()->route('home')->with('success', 'Product created successfully.');
        }else{
            abort(404);
        }
    }


    public function delete($id)
    {
        $this->productRepository->delete($id);
    }


    public function editProduct($id)
    {
        [$product, $categories] = $this->productRepository->editProduct($id);
        $cartItemCount = $this->cartRepository->getCartItemCountByUserId(Auth::id());
        return view('admin.productUpdate', compact('product', 'cartItemCount', 'categories'));
    }


    public function editProductStore(Request $request, $id)
    {
        $this->productRepository->store($request, $id);
        return redirect()->route('home');
    }


    public function showProduct($id)
    {
        [$products, $images] = $this->productRepository->showProduct($id);
        $cartItemCount = $this->cartRepository->getCartItemCountByUserId(Auth::id());
        return view('admin.productDetails', compact('products', 'images', 'cartItemCount'));
    }


    public function products()
    {
        [$products, $images, $categories] = $this->productRepository->products();
        $cartItemCount = $this->cartRepository->getCartItemCountByUserId(Auth::id());
        return view('admin.products', compact('products', 'images', 'cartItemCount', 'categories'));
    }

    public function addToCart(Request $request)
    {
        $result = $this->productRepository->addToCart($request);
            return $result;

    }


    public function getCartCount()
    {
        $response = $this->productRepository->getCartCount();
        return $response;
    }
}
