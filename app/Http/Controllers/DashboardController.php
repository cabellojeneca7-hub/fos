<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Metric Cards Data
        $itemSales = Order::sum('total');
        $newOrders = Order::whereDate('created_at', now())->count();
        $totalProducts = MenuItem::count();
        $uniqueVisitors = User::count(); // Simplified for demo

        // 2. Sales Report Chart Data (Last 6 Months)
        $salesData = Order::select(
            DB::raw('SUM(total) as total'),
            DB::raw("DATE_FORMAT(created_at, '%b') as month")
        )
        ->groupBy('month')
        ->orderBy('created_at', 'asc')
        ->take(6)
        ->get();

        // 3. Weekly Top Sellers (Top 5)
        $topSellers = DB::table('order_items')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->select('menu_items.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('menu_items.name')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'itemSales', 
            'newOrders', 
            'totalProducts', 
            'uniqueVisitors',
            'salesData',
            'topSellers'
        ));
    }
}
