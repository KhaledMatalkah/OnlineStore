<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderItemsController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function placeOrder(Request $request)
    {
        $result = $this->orderRepository->placeOrder($request);
        return $result;
    }
}
