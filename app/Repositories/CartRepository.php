<?php

namespace App\Repositories;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartRepository implements CartRepositoryInterface
{

    public function getCartItemCountByUserId($userId)
    {
        // Your existing code to fetch the cart item count
        $cartItem = CartItem::where('user_id', $userId)
            ->where('deleted', false)
            ->with('product')
            ->get();
        $cartItemCount = $cartItem->sum('quantity');

        return $cartItemCount;
    }

    public function cartItems()
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $carts = CartItem::where('user_id', $userId)
                ->where('deleted', false)
                ->with('product')
                ->get();
            if ($carts->isEmpty()) {
                $message = "You didn't add any products to your Cart";
                return $message;
            } else {
                return $carts;
            }
        } else {
            throw new AuthenticationException('User not authenticated.');
        }
    }

    public function deleteCart($id, Request $request)
    {
        if (Auth::check()) {
            $cart = CartItem::find($id);
            if ($cart && $request->quantity > 0) {
                $cart->delete();
                return true;
            }
        } else {
            return false;
        }
    }

    public function updateQuantity($id, Request $request)
    {
        $cart = CartItem::find($id);
        $quantity = $request->input('quantity');
        $product = Product::find($cart->product_id);

        if ($cart && ($quantity >= 0) && ($quantity <= $product->quantity)) {
            $cart->quantity = $quantity;
            $cart->save();
            return response()->json(['success' => 'Product quantity updated successfully!']);
        } else {
            return response()->json(['error' => 'Invalid quantity or reached the limit!']);
        }
    }
}
