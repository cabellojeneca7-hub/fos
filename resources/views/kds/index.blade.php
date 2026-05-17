<x-app-layout>
    <div class="mb-8 flex justify-between items-center" x-data="{ timer: 30 }" x-init="setInterval(() => { if(timer > 0) timer--; else window.location.reload(); }, 1000)">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Kitchen Display System (KDS)</h1>
            <p class="text-gray-500">Active orders currently being prepared.</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="bg-blue-50 px-4 py-2 rounded-xl border border-blue-100 flex items-center space-x-2">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Auto-refresh in</span>
                <span class="text-xl font-black text-blue-800" x-text="timer + 's'"></span>
            </div>
            <button onclick="window.location.reload()" class="bg-white p-2 rounded-xl shadow-sm hover:shadow-md transition active:scale-95">
                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            </button>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-[3rem] p-20 text-center shadow-sm border border-gray-100 flex flex-col items-center justify-center">
            <div class="bg-green-50 h-20 w-20 rounded-full flex items-center justify-center mb-6">
                <svg class="h-10 w-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800">No pending orders</h3>
            <p class="text-gray-500 mt-2">The kitchen is all caught up. Great job!</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($orders as $order)
                <div class="bg-white rounded-[2rem] shadow-sm border-t-8 border-blue-600 flex flex-col overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6 border-b border-gray-50">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-black text-blue-600 tracking-widest uppercase">Order #{{ $order->id }}</span>
                            <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-blue-50 text-blue-700">
                                {{ $order->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800">{{ $order->customer_name }}</h4>
                    </div>

                    <div class="p-6 flex-1 space-y-4">
                        @foreach($order->orderItems as $item)
                            <div class="flex items-start space-x-3">
                                <div class="bg-gray-100 text-gray-800 font-black text-sm h-8 w-8 rounded-lg flex items-center justify-center flex-shrink-0">
                                    {{ $item->quantity }}
                                </div>
                                <div class="text-sm font-bold text-gray-700 pt-1">
                                    {{ $item->menuItem->name }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="p-6 bg-gray-50">
                        <form action="{{ route('orders.update', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="ready">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-2xl transition shadow-lg shadow-green-100 active:scale-95 flex items-center justify-center space-x-2">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Mark as Ready</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
