<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\CartRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{
    protected $cartRepository;
    protected $categoryRepository;

    public function __construct(CartRepositoryInterface $cartRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function addCategory()
    {
        $categories = $this->categoryRepository->addCategory();
        $cartItemCount = $this->cartRepository->getCartItemCountByUserId(Auth::id());
        return view('admin.addCategory', compact('categories', 'cartItemCount'));
    }

    public function addToCategory(Request $request)
    {
        $result = $this->categoryRepository->addToCategory($request);
        return $result;
    }

    public function show($id)
    {
        [$category, $products] = $this->categoryRepository->show($id);
        $cartItemCount = $this->cartRepository->getCartItemCountByUserId(Auth::id());
        if(false){
            abort(404);
        }else{
            return view('category', compact('category', 'products', 'cartItemCount'));
        }
    }

    public function delete($id)
    {
        $result = $this->categoryRepository->delete($id);
        return $result;
    }
}
