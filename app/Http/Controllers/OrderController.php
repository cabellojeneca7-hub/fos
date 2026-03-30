<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function generateReceipt(Order $order)
    {
        $order->load('orderItems.menuItem');
        
        // Update status to paid
        $order->update(['status' => 'paid']);

        $pdf = Pdf::loadView('orders.receipt', compact('order'));
        return $pdf->download("receipt-order-{$order->id}.pdf");
    }

    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        $dailySales = Order::whereDate('created_at', now())->sum('total');
        return view('orders.index', compact('orders', 'dailySales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $menuItem = MenuItem::findOrFail($request->menu_item_id);

        if ($menuItem->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Sorry, not enough stock available!');
        }

        $total = $menuItem->price * $request->quantity;

        $order = Order::create([
            'customer_name' => $request->customer_name ?? 'Walk-in',
            'total' => $total,
            'status' => 'preparing'
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'menu_item_id' => $menuItem->id,
            'quantity' => $request->quantity,
            'price' => $menuItem->price
        ]);

        // Decrease stock
        $menuItem->decrement('stock', $request->quantity);

        return redirect()->route('menu.index')->with('success', 'Order placed successfully!');
    }

    public function update(Request $request, Order $order)
    {
        $order->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Order status updated!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->back()->with('success', 'Order deleted!');
    }
}
