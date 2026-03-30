<x-app-layout>
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Order Queue</h1>
            <p class="text-gray-500">Manage and track all incoming orders.</p>
        </div>
        <div class="bg-green-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-green-200 flex items-center space-x-2">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>Daily Sales: ₱{{ number_format($dailySales, 2) }}</span>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-blue-600 text-white px-6 py-4 rounded-2xl shadow-lg mb-8 flex items-center space-x-3 animate-pulse">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-[2rem] shadow-sm overflow-hidden border border-gray-100">
        <div class="p-8">
            <table class="min-w-full">
                <thead>
                    <tr class="text-left">
                        <th class="pb-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Order ID</th>
                        <th class="pb-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Customer</th>
                        <th class="pb-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Total</th>
                        <th class="pb-6 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Status</th>
                        <th class="pb-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Time</th>
                        <th class="pb-6 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                        <tr class="group hover:bg-gray-50 transition duration-150">
                            <td class="py-6 whitespace-nowrap">
                                <span class="bg-gray-100 text-gray-800 text-xs font-bold px-3 py-1 rounded-lg">#{{ $order->id }}</span>
                            </td>
                            <td class="py-6 whitespace-nowrap text-sm font-semibold text-gray-800">{{ $order->customer_name }}</td>
                            <td class="py-6 whitespace-nowrap text-sm font-bold text-blue-600">₱{{ number_format($order->total, 2) }}</td>
                            <td class="py-6 whitespace-nowrap text-center">
                                <span class="px-4 py-1.5 inline-flex text-xs leading-5 font-bold rounded-full {{ $order->status === 'paid' ? 'bg-blue-100 text-blue-600' : ($order->status === 'ready' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="py-6 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->diffForHumans() }}</td>
                            <td class="py-6 whitespace-nowrap text-right space-x-2">
                                @if($order->status === 'preparing')
                                    <form action="{{ route('orders.update', $order) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="ready">
                                        <button type="submit" class="bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white px-4 py-2 rounded-xl text-xs font-bold transition duration-200">
                                            Mark Ready
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('orders.receipt', $order) }}" 
                                   onclick="setTimeout(() => window.location.reload(), 500)"
                                   class="bg-green-50 text-green-600 hover:bg-green-600 hover:text-white px-4 py-2 rounded-xl text-xs font-bold transition duration-200 inline-block">
                                    Receipt
                                </a>
                                <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white px-4 py-2 rounded-xl text-xs font-bold transition duration-200" onclick="return confirm('Delete this order?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-500 italic">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

<script>
    setTimeout(function() {
        window.location.reload();
    }, 30000);
</script>