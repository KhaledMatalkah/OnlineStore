<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Repositories\CartRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CartController extends Controller
{
    protected $cartRepository;
    protected $productRepository;

    public function __construct(CartRepositoryInterface $cartRepository, ProductRepositoryInterface $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    public function getCartItemCountByUserId($userId)
    {
        $cartItemCount = $this->cartRepository->cartItems($userId);
        return $cartItemCount;
    }

    public function cartItems()
    {
        try {
            $cartItemCount = $this->cartRepository->getCartItemCountByUserId(Auth::id());
            $result = $this->cartRepository->cartItems();
            if (is_string($result)) {
                $message = $result;
                return view('cartItems', compact('message', 'cartItemCount'));
            } else {
                $carts = $result;
                return view('cartItems', compact('carts', 'cartItemCount'));
            }
        } catch (AuthenticationException $e) {
            return redirect()->route('login');
        }
    }


    public function deleteCart($id, Request $request)
    {
        $result = $this->cartRepository->deleteCart($id, $request);
        if ($result === true) {
            return response()->json(['success' => 'Product Deleted Successfully']);
        } else {
            abort(404);
        }
    }


    public function updateQuantity($id, Request $request)
{
    $result = $this->cartRepository->updateQuantity($id, $request);
    return $result;
}
}
