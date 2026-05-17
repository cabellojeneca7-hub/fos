<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class KdsController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderItems.menuItem')
            ->where('status', 'preparing')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('kds.index', compact('orders'));
    }
}
