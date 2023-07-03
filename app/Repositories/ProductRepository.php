<?php

namespace App\Repositories;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductRepository implements ProductRepositoryInterface
{
    public function create()
    {
        $categories = Category::all();
        return $categories;
    }


    public function store(Request $request, $id = null)
    {
        if ($id) {
            $product = Product::find($id);
            if (!$product) {
                return false;
            }
        } else {
            $product = new Product();
        }

        // Update the product's attributes
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;

        // Store the selected category
        $product->category_id = $request->category;

        $product->save();

        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move('public/images', $filename);

                $imageModel = new Image();
                $imageModel->name = $filename;
                $imageModel->product_id = $product->id;
                $imageModel->timestamps = true;
                $imageModel->save();
            }
        }

        return true;
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
    }



    public function editProduct($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        if (!$product) {
            return abort(404);
        }
        return [$product, $categories];
    }

    public function showProduct($id)
    {
        $product = Product::find($id);
        $images = Image::where('product_id', $id)->get();
        if (!$product || !$images) {
            return abort(404);
        }
        return [$product, $images];
    }

    public function products()
    {
        $categories = Category::all();

        $products = Product::all();
        $images = Image::all();
        if (!$products || !$images) {
            return abort(404);
        }
        return [$products, $images, $categories];
    }

    public function addToCart(Request $request)
{
    $validatedData = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    // Retrieve the validated data
    $productId = $validatedData['product_id'];
    $quantity = $validatedData['quantity'];

    // Check if the product exists
    $product = Product::find($productId);
    if (!$product) {
        return response()->json(['error' => 'Product not found!']);
    }

    // Check if the product quantity is greater than zero
    if ($product->quantity == 0) {
        return response()->json(['error' => 'Quanityt Is Out Of Stock!']);
    }

    // Add the product to the user's cart
    $userId = Auth::id();
    $cartItem = CartItem::where('user_id', $userId)
        ->where('product_id', $productId)
        ->where('deleted', false)
        ->with('product')
        ->first();

        if ($cartItem && ($cartItem->quantity + 1) <= $product->quantity) {
            $cartItem->quantity += 1; // Increase quantity by 1
            $cartItem->save();
            return response()->json(['success' => 'Product added to cart successfully!']);
        } elseif(!$cartItem) {
                $cartItem = new CartItem();
                $cartItem->user_id = $userId;
                $cartItem->product_id = $productId;
                $cartItem->quantity = $quantity;
                $cartItem->timestamps = true;
                $cartItem->save();
        }else{
            return response()->json(['error' => 'You have reached the limit of the product quantity!']);
        }
}




    public function getCartCount()
    {
            $userId = Auth::id();
            $cartItem = CartItem::where('user_id', $userId)
                ->where('deleted', false)
                ->with('product')
                ->get();
            $cartItemCount = $cartItem->sum('quantity');
            return response()->json(['cartItemCount' => $cartItemCount]);
    }
}
