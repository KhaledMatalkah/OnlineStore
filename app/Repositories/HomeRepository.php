<?php

namespace App\Repositories;

use App\Models\Product;

class HomeRepository implements HomeRepositoryInterface
{
    public function index()
    {
        $products = Product::inRandomOrder()->take(3)->with('images')->get();
        return $products;
    }
}
