<x-app-layout>
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Food Menu</h1>
            <p class="text-gray-500">Pick your favorite items and place your order.</p>
        </div>
        <div class="flex space-x-3">
            <form action="{{ route('menu.index') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search menu items..." class="bg-white border-none rounded-xl py-2 px-4 pr-10 shadow-sm focus:ring-2 focus:ring-blue-500 w-64 text-sm">
                <button type="submit" class="absolute right-3 top-2 text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
        </div>
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

    @foreach($categories as $category)
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <span class="w-2 h-8 bg-blue-600 rounded-full mr-3"></span>
                    {{ $category->name }}
                </h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($category->menuItems as $menuItem)
                    <div class="bg-white rounded-[2rem] p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-transparent hover:border-blue-100 group {{ $menuItem->stock <= 0 ? 'opacity-75 grayscale-[0.5]' : '' }}">
                        <div class="aspect-square bg-gray-50 rounded-[1.5rem] mb-6 flex items-center justify-center relative overflow-hidden">
                            @if($menuItem->image)
                                <img src="{{ $menuItem->image }}" alt="{{ $menuItem->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <svg class="h-20 w-20 text-gray-200 group-hover:scale-110 transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            @endif
                            
                            <div class="absolute top-4 right-4 bg-white/95 backdrop-blur px-3 py-1.5 rounded-full text-blue-600 font-bold text-xs shadow-sm">
                                ₱{{ number_format($menuItem->price, 2) }}
                            </div>
                        </div>

                        <h4 class="font-bold text-lg text-gray-800 mb-4">{{ $menuItem->name }}</h4>
                        
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="menu_item_id" value="{{ $menuItem->id }}">
                            <div class="space-y-4">
                                <div class="flex items-center space-x-2">
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $menuItem->stock }}" class="w-20 bg-gray-50 border-none rounded-xl py-2 px-4 text-sm focus:ring-2 focus:ring-blue-500 shadow-inner font-bold text-center" {{ $menuItem->stock <= 0 ? 'disabled' : '' }}>
                                    @if($menuItem->stock > 0)
                                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl transition shadow-lg shadow-blue-200 active:scale-95">
                                            Add to Cart
                                        </button>
                                    @else
                                        <button type="button" disabled class="flex-1 bg-gray-200 text-gray-500 font-bold py-2 px-4 rounded-xl cursor-not-allowed">
                                            Out of Stock
                                        </button>
                                    @endif
                                </div>
                                <div class="text-center mt-2">
                                    <span class="text-xs font-bold {{ $menuItem->stock < 10 ? 'text-red-500' : 'text-gray-400' }}">
                                        Available Stock: {{ $menuItem->stock }}
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</x-app-layout>