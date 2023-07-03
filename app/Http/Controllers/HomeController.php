<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Image;
use App\Models\Product;
use App\Repositories\CartRepositoryInterface;
use App\Repositories\HomeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


     protected $cartRepository;
    protected $homeRepository;

    public function __construct(CartRepositoryInterface $cartRepository, HomeRepositoryInterface $homeRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->homeRepository = $homeRepository;
    }
    public function index()
    {
        $products = $this->homeRepository->index();
        $cartItemCount = $this->cartRepository->getCartItemCountByUserId(auth()->id());
        return view('home', compact('products', 'cartItemCount'));
    }
}
