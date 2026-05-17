<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function getCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        }

        $sessionId = Session::getId();
        return Cart::firstOrCreate(['session_id' => $sessionId]);
    }

    public function index()
    {
        $cart = $this->getCart();
        $cart->load('cartItems.menuItem');
        
        $total = $cart->cartItems->sum(function ($item) {
            return $item->menuItem->price * $item->quantity;
        });

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $menuItem = MenuItem::findOrFail($request->menu_item_id);
        
        if ($menuItem->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Not enough stock available!');
        }

        $cart = $this->getCart();

        $cartItem = $cart->cartItems()->where('menu_item_id', $menuItem->id)->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($menuItem->stock < $newQuantity) {
                return redirect()->back()->with('error', "Cannot add more. Only {$menuItem->stock} items in stock.");
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            $cart->cartItems()->create([
                'menu_item_id' => $menuItem->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $menuItem = $cartItem->menuItem;
        if ($menuItem->stock < $request->quantity) {
            return redirect()->back()->with('error', "Only {$menuItem->stock} items available in stock.");
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();
        return redirect()->back()->with('success', 'Item removed from cart!');
    }
}
