<x-app-layout>
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Menu Management</h1>
            <p class="text-gray-500">Add, edit, or remove items from your menu.</p>
        </div>
        <div class="flex space-x-3 items-center">
            <form action="{{ route('admin.menu-items.index') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search menu..." class="bg-white border-none rounded-xl py-2 px-4 pr-10 shadow-sm focus:ring-2 focus:ring-blue-500 w-64 text-sm">
                <button type="submit" class="absolute right-3 top-2 text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
            <a href="{{ route('admin.menu-items.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-blue-200 flex items-center space-x-2 active:scale-95 transition">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                <span>Add Item</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-blue-600 text-white px-6 py-4 rounded-2xl shadow-lg mb-8 flex items-center space-x-3">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-[2rem] shadow-sm overflow-hidden border border-gray-100">
        <div class="p-8">
            <table class="min-w-full">
                <thead>
                    <tr class="text-left">
                        <th class="pb-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Item</th>
                        <th class="pb-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Category</th>
                        <th class="pb-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Price</th>
                        <th class="pb-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Stock</th>
                        <th class="pb-6 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($menuItems as $item)
                        <tr class="group hover:bg-gray-50 transition duration-150">
                            <td class="py-6 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    @if($item->image)
                                        <img src="{{ $item->image }}" class="h-12 w-12 rounded-xl object-cover">
                                    @else
                                        <div class="h-12 w-12 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    <span class="text-sm font-semibold text-gray-800">{{ $item->name }}</span>
                                </div>
                            </td>
                            <td class="py-6 whitespace-nowrap text-sm text-gray-500 font-medium">{{ $item->category->name }}</td>
                            <td class="py-6 whitespace-nowrap text-sm font-bold text-blue-600">₱{{ number_format($item->price, 2) }}</td>
                            <td class="py-6 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-bold rounded-lg {{ $item->stock < 10 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                    {{ $item->stock }} Left
                                </span>
                            </td>
                            <td class="py-6 whitespace-nowrap text-right space-x-2">
                                <a href="{{ route('admin.menu-items.edit', $item) }}" class="text-gray-400 hover:text-blue-600 transition inline-block">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.menu-items.destroy', $item) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition" onclick="return confirm('Are you sure?')">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-500 italic">No menu items found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>