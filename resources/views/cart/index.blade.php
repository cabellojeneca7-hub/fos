<x-app-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Your Shopping Cart</h1>
        <p class="text-gray-500">Review your items and proceed to checkout.</p>
    </div>

    @if(session('success'))
        <div class="bg-blue-600 text-white px-6 py-4 rounded-2xl shadow-lg mb-8 flex items-center space-x-3">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-600 text-white px-6 py-4 rounded-2xl shadow-lg mb-8 flex items-center space-x-3">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    @if($cart->cartItems->isEmpty())
        <div class="bg-white rounded-[2rem] p-12 text-center shadow-sm border border-gray-100">
            <div class="mb-6 flex justify-center">
                <div class="bg-gray-50 p-6 rounded-full">
                    <svg class="h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">Your cart is empty</h2>
            <p class="text-gray-500 mb-8">Looks like you haven't added anything to your cart yet.</p>
            <a href="{{ route('menu.index') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-lg shadow-blue-200 active:scale-95">
                Browse Menu
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart->cartItems as $item)
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 flex items-center space-x-6">
                        <div class="h-24 w-24 bg-gray-50 rounded-2xl overflow-hidden flex-shrink-0">
                            @if($item->menuItem->image)
                                <img src="{{ $item->menuItem->image }}" alt="{{ $item->menuItem->name }}" class="h-full w-full object-cover">
                            @else
                                <div class="h-full w-full flex items-center justify-center">
                                    <svg class="h-10 w-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-gray-800">{{ $item->menuItem->name }}</h3>
                            <p class="text-blue-600 font-bold">₱{{ number_format($item->menuItem->price, 2) }}</p>
                        </div>

                        <div class="flex items-center space-x-4">
                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->menuItem->stock }}" class="w-20 bg-gray-50 border-none rounded-xl py-2 px-4 text-sm focus:ring-2 focus:ring-blue-500 shadow-inner font-bold text-center">
                                <button type="submit" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Update Quantity">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </button>
                            </form>

                            <form action="{{ route('cart.remove', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Remove Item">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 sticky top-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Order Summary</h3>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-gray-500">
                            <span>Subtotal</span>
                            <span>₱{{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-800 font-bold text-xl pt-4 border-t border-gray-50">
                            <span>Total</span>
                            <span class="text-blue-600">₱{{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <form action="{{ route('orders.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Customer Name</label>
                            <input type="text" name="customer_name" placeholder="Enter name for order" required class="w-full bg-gray-50 border-none rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-blue-500 shadow-inner">
                        </div>
                        
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-2xl transition shadow-lg shadow-blue-200 active:scale-95 text-lg">
                            Place Order
                        </button>
                    </form>
                    
                    <p class="text-center text-xs text-gray-400 mt-6">
                        By placing your order, you agree to our terms of service.
                    </p>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
