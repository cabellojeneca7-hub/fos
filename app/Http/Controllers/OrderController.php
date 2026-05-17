<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    private function getCart()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->first();
        }

        $sessionId = Session::getId();
        return Cart::where('session_id', $sessionId)->first();
    }

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
            'customer_name' => 'required|string|max:255',
        ]);

        $cart = $this->getCart();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('menu.index')->with('error', 'Your cart is empty!');
        }

        try {
            DB::beginTransaction();

            $total = 0;
            $orderItemsData = [];

            // 1. Validate all items and calculate total
            foreach ($cart->cartItems as $cartItem) {
                $menuItem = $cartItem->menuItem;

                if ($menuItem->stock < $cartItem->quantity) {
                    throw new \Exception("Insufficient stock for {$menuItem->name}. Only {$menuItem->stock} left.");
                }

                $itemTotal = $menuItem->price * $cartItem->quantity;
                $total += $itemTotal;

                $orderItemsData[] = [
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $menuItem->price,
                    'menu_item' => $menuItem // Keep reference for stock update
                ];
            }

            // 2. Create the Order
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'total' => $total,
                'status' => 'preparing'
            ]);

            // 3. Create OrderItems and Decrease Stock
            foreach ($orderItemsData as $itemData) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $itemData['menu_item_id'],
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price']
                ]);

                $itemData['menu_item']->decrement('stock', $itemData['quantity']);
            }

            // 4. Clear the Cart
            $cart->cartItems()->delete();
            $cart->delete();

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
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
