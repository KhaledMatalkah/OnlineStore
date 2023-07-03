<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface OrderRepositoryInterface
{
    public function placeOrder(Request $request);
}

