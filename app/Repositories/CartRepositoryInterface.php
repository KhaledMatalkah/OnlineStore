<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface CartRepositoryInterface
{
    public function cartItems();
    public function getCartItemCountByUserId($userId);
    public function deleteCart($id , Request $request);
    public function updateQuantity($id , Request $request);
}
