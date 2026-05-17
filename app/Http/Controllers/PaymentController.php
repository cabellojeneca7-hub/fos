<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    private function getCart()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->first();
        }
        return Cart::where('session_id', Session::getId())->first();
    }

    public function checkout(Request $request)
    {
        $cart = $this->getCart();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('menu.index')->with('error', 'Your cart is empty!');
        }

        $subtotal = $cart->cartItems->sum(function ($item) {
            return $item->menuItem->price * $item->quantity;
        });

        $taxRate = 0.12; // 12% VAT
        $taxAmount = $subtotal * $taxRate;
        $discountAmount = 0.00;
        $total = $subtotal + $taxAmount - $discountAmount;

        $customerName = $request->customer_name;

        return view('checkout.index', compact('cart', 'subtotal', 'taxAmount', 'discountAmount', 'total', 'customerName'));
    }

    public function processMockPaypal(Request $request)
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

            $subtotal = 0;
            $orderItemsData = [];

            // 1. Validate stock and calculate subtotal
            foreach ($cart->cartItems as $cartItem) {
                $menuItem = $cartItem->menuItem;

                if ($menuItem->stock < $cartItem->quantity) {
                    throw new \Exception("Insufficient stock for {$menuItem->name}. Only {$menuItem->stock} left.");
                }

                $subtotal += $menuItem->price * $cartItem->quantity;

                $orderItemsData[] = [
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $menuItem->price,
                    'menu_item' => $menuItem
                ];
            }

            $taxRate = 0.12;
            $taxAmount = $subtotal * $taxRate;
            $discountAmount = 0.00;
            $total = $subtotal + $taxAmount - $discountAmount;

            // 2. Create the Order with Payment Details
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'total' => $total,
                'status' => 'preparing',
                'payment_method' => 'Prototype PayPal',
                'transaction_id' => 'PAYPAL-MOCK-' . strtoupper(Str::random(12))
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

            return redirect()->route('orders.index')->with('success', "Order placed successfully! Transaction ID: {$order->transaction_id}");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }
}
