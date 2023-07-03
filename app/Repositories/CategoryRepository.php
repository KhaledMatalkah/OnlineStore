<?php

namespace App\Repositories;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function addCategory()
    {
        $categories = Category::all();
        return $categories;
    }

    public function addToCategory(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        // Create a new category
        $category = new Category();
        $category->name = $validatedData['name'];
        $category->save();

        return response()->json(['name' => $category->name]);
    }

    public function show($id)
    {
        // Retrieve the category and its products based on the provided ID
        $category = Category::findOrFail($id);
        if ($category) {
            $products = $category->products;
            // Pass the category and products to the view
            return [$category, $products];
        }
        else{
            return false;
        }
    }

    public function delete($id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Check if the user has admin role
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Check if the category exists
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        // Check if the category ID is used in a product
        $usedInProduct = Product::where('category_id', $id)->exists();
        if ($usedInProduct) {
            return response()->json(['error' => 'Cannot delete category. It is used in a product'], 422);
        }

        // Delete the category
        $category->delete();

        return response()->json(['success' => 'Category deleted successfully']);
    }
}
