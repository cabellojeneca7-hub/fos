<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Order History') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('View your past orders and their status.') }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @forelse($orders as $order)
            <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h4 class="font-bold text-gray-800">Order #{{ $order->id }}</h4>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest
                            {{ $order->status === 'ready' ? 'bg-green-100 text-green-700' : 
                               ($order->status === 'preparing' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">
                            {{ $order->status }}
                        </span>
                        <p class="mt-1 font-black text-blue-600">₱{{ number_format($order->total, 2) }}</p>
                    </div>
                </div>

                <div class="space-y-2">
                    @foreach($order->orderItems as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ $item->menuItem->name }} x {{ $item->quantity }}</span>
                            <span class="text-gray-400 font-medium">₱{{ number_format($item->price * $item->quantity, 2) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                    <span class="text-xs text-gray-400">Transaction ID: {{ $order->transaction_id ?? 'N/A' }}</span>
                    <a href="{{ route('orders.receipt', $order) }}" class="text-xs font-bold text-blue-600 hover:underline">Download Receipt</a>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <p class="text-sm text-gray-600">{{ __('No orders found.') }}</p>
                <a href="{{ route('menu.index') }}" class="mt-4 inline-block text-blue-600 font-bold hover:underline">{{ __('Start Ordering') }}</a>
            </div>
        @endforelse
    </div>
</section>
