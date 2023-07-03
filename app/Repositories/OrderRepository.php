<?php

namespace App\Repositories;

use App\Models\CartItem;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderRepository implements OrderRepositoryInterface
{
    public function placeOrder(Request $request)
    {
        // Get all items from the cartItems table where deleted = false
        $cartItems = CartItem::where('user_id', Auth::id())->where('deleted', false)->get();
        if ($request->input('address') == '') {
            return response()->json(['error' => 'Add Your Address!']);
        }
        
        // Check if there are any cart items
        if ($cartItems->count() > 0) {
            $ItemsQuantity = 0;
            $totalPrice = 0;

            foreach ($cartItems as $cartItem) {
                if ($cartItem->deleted == 0) {
                    $product = Product::find($cartItem->product_id);
                    if ($product->quantity > 0) {
                        $availableQuantity = $product->quantity - $cartItem->quantity;

                        // Subtract the cart quantity from the available quantity of the product
                        $product->quantity = $availableQuantity;
                        $product->save();

                        $ItemsQuantity += $cartItem->quantity;
                        $itemPrice = $product->price * $cartItem->quantity;
                        $totalPrice += $itemPrice;
                    } else {
                        break;
                    }
                }
            }

            foreach ($cartItems as $cartItem) {
                if ($cartItem->deleted == 0) {
                    $order = new OrderItems();
                    $order->user_id = Auth::id();
                    $order->product_id = $cartItem->product_id;
                    $order->quantity = $ItemsQuantity;
                    $order->price = $totalPrice;
                    $order->address = $request->input('address');
                    $order->save();
                }
            }

            // Mark cart items as deleted
            foreach ($cartItems as $cartItem) {
                $cartItem->deleted = true;
                $cartItem->save();
            }

            return response()->json(['success' => 'Your Order Has Been Placed Successfuly!']);
        } else {
            return response()->json(['error' => 'Your Cart Is Empty!']);
        }
    }
}
