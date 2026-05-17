<x-app-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Checkout Summary</h1>
        <p class="text-gray-500">Review your order details and complete payment via Prototype PayPal.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Order Details</h3>
                <div class="space-y-4">
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Customer Name</span>
                        <span class="font-bold text-gray-800">{{ $customerName }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Payment Method</span>
                        <span class="font-bold text-blue-600">Prototype PayPal</span>
                    </div>
                </div>

                <div class="mt-8">
                    <h4 class="font-bold text-gray-800 mb-4">Items</h4>
                    <div class="space-y-3">
                        @foreach($cart->cartItems as $item)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ $item->menuItem->name }} x {{ $item->quantity }}</span>
                                <span class="font-medium">₱{{ number_format($item->menuItem->price * $item->quantity, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 rounded-[2rem] p-8 border border-blue-100 flex items-start space-x-4">
                <div class="bg-blue-600 p-3 rounded-2xl text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-blue-900 mb-1">Prototype Mode</h4>
                    <p class="text-blue-700 text-sm">
                        This is a simulated payment flow for demonstration purposes. No actual funds will be transferred.
                    </p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 sticky top-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Payment Summary</h3>
                
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between text-gray-500">
                        <span>Subtotal</span>
                        <span>₱{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-500">
                        <span>Tax (VAT 12%)</span>
                        <span>₱{{ number_format($taxAmount, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-500">
                        <span>Discount</span>
                        <span>-₱{{ number_format($discountAmount, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-800 font-bold text-2xl pt-4 border-t border-gray-50">
                        <span>Total</span>
                        <span class="text-blue-600">₱{{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="customer_name" value="{{ $customerName }}">
                    
                    <button type="submit" class="w-full bg-[#0070ba] hover:bg-[#005ea6] text-white font-bold py-4 px-8 rounded-2xl transition shadow-lg shadow-blue-200 active:scale-95 text-lg flex items-center justify-center space-x-3">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor"><path d="M20.067 8.478c.492.88.556 2.014.3 3.327-.74 3.806-3.27 5.12-6.514 5.12h-.5a.805.805 0 0 0-.794.68l-.04.22-.63 3.993-.03.17a.805.805 0 0 1-.794.679H7.72a.483.483 0 0 1-.477-.558L7.418 21a.483.483 0 0 1 .477-.403h1.348c.394 0 .72-.3.774-.69l.642-4.062.03-.171a.805.805 0 0 1 .794-.679h.5c3.626 0 6.452-1.472 7.288-5.776.285-1.472.158-2.57-.514-3.32-.236-.264-.515-.492-.83-.684l.024-.15a.483.483 0 0 1 .477-.404h2.24c.264 0 .48.216.48.48l-.014.13zM13.684 3c.492.88.556 2.014.3 3.327-.74 3.806-3.27 5.12-6.514 5.12h-.5a.805.805 0 0 0-.794.68l-.04.22-.63 3.992-.03.17a.805.805 0 0 1-.794.679H1.336a.483.483 0 0 1-.477-.558L1.034 15.541a.483.483 0 0 1 .477-.403H2.86c.393 0 .72-.3.773-.69l.643-4.062.03-.171a.805.805 0 0 1 .794-.679h.5c3.626 0 6.452-1.472 7.288-5.776.285-1.472.158-2.57-.514-3.32A3.13 3.13 0 0 0 10.15 3h3.534z"/></svg>
                        <span>Pay with PayPal</span>
                    </button>
                </form>

                <div class="mt-6">
                    <a href="{{ route('cart.index') }}" class="block text-center text-sm font-bold text-gray-500 hover:text-gray-700 transition">
                        Back to Cart
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
