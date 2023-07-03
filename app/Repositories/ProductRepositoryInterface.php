<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public function store(Request $request);
    public function editProduct($id);
    public function showProduct($id);
    public function products();
    public function addToCart(Request $request);
    public function getCartCount();
    public function create();
    public function delete($id);
}
