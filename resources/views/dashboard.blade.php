<x-app-layout>
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">General Report</h1>
            <p class="text-gray-500">Real-time business analytics and insights.</p>
        </div>
        <button onclick="window.location.reload()" class="bg-white text-blue-600 px-4 py-2 rounded-xl font-bold shadow-sm flex items-center space-x-2 active:scale-95 transition">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            <span>Reload Data</span>
        </button>
    </div>

    <!-- Metric Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Item Sales -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-50">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 rounded-2xl bg-blue-100 text-blue-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <span class="text-xs font-bold px-2 py-1 rounded-full bg-green-100 text-green-600">33% ↑</span>
            </div>
            <div class="text-2xl font-bold text-gray-800 mb-1">₱{{ number_format($itemSales, 2) }}</div>
            <div class="text-sm text-gray-500">Item Sales</div>
        </div>

        <!-- New Orders -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-50">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 rounded-2xl bg-orange-100 text-orange-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <span class="text-xs font-bold px-2 py-1 rounded-full bg-red-100 text-red-600">2% ↓</span>
            </div>
            <div class="text-2xl font-bold text-gray-800 mb-1">{{ $newOrders }}</div>
            <div class="text-sm text-gray-500">New Orders</div>
        </div>

        <!-- Total Products -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-50">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 rounded-2xl bg-green-100 text-green-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <span class="text-xs font-bold px-2 py-1 rounded-full bg-green-100 text-green-600">12% ↑</span>
            </div>
            <div class="text-2xl font-bold text-gray-800 mb-1">{{ $totalProducts }}</div>
            <div class="text-sm text-gray-500">Total Products</div>
        </div>

        <!-- Unique Visitor -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-50">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 rounded-2xl bg-purple-100 text-purple-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <span class="text-xs font-bold px-2 py-1 rounded-full bg-green-100 text-green-600">22% ↑</span>
            </div>
            <div class="text-2xl font-bold text-gray-800 mb-1">{{ $uniqueVisitors }}</div>
            <div class="text-sm text-gray-500">Unique Visitors</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sales Report Chart -->
        <div class="lg:col-span-2 bg-white p-8 rounded-[2rem] shadow-sm border border-gray-50">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-800">Sales Report</h3>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 bg-blue-600 rounded-full"></span>
                        <span class="text-xs text-gray-500 font-bold">Monthly Trend</span>
                    </div>
                </div>
            </div>
            <div class="h-80">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Inventory Alerts -->
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-50">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-800">Inventory Alerts</h3>
                @if($outOfStockCount > 0)
                    <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-1 rounded-full">{{ $outOfStockCount }} Out of Stock</span>
                @endif
            </div>
            
            <div class="space-y-4">
                @forelse($lowStockItems as $item)
                    <div class="flex items-center justify-between p-3 rounded-2xl bg-orange-50 border border-orange-100">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 rounded-lg bg-white text-orange-600 shadow-sm">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-gray-800">{{ $item->name }}</div>
                                <div class="text-[10px] text-orange-600 font-medium">Only {{ $item->stock }} left</div>
                            </div>
                        </div>
                        <a href="{{ route('admin.menu-items.edit', $item) }}" class="text-[10px] font-bold text-blue-600 hover:underline">Restock</a>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="bg-green-50 h-12 w-12 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <p class="text-xs text-gray-500">All items are well stocked!</p>
                    </div>
                @endforelse
            </div>

            <!-- Top Sellers List (Moved down) -->
            <div class="mt-10">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Top Sellers</h3>
                <div class="space-y-4">
                    @foreach($topSellers as $seller)
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-gray-700">{{ $seller->name }}</span>
                            <span class="text-xs font-bold text-blue-600">{{ $seller->total_sold }} sold</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($salesData->pluck('month')) !!},
                datasets: [{
                    label: 'Monthly Sales',
                    data: {!! json_encode($salesData->pluck('total')) !!},
                    borderColor: '#1e3a8a',
                    backgroundColor: 'rgba(30, 58, 138, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { font: { size: 10 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10 } }
                    }
                }
            }
        });
    </script>
</x-app-layout>