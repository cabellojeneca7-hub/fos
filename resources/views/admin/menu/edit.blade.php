<x-app-layout>
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Menu Item</h1>
            <p class="text-gray-500">Update details for {{ $menuItem->name }}.</p>
        </div>
        <a href="{{ route('admin.menu-items.index') }}" class="bg-gray-100 text-gray-800 px-6 py-3 rounded-2xl font-bold shadow-sm flex items-center space-x-2 active:scale-95 transition">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Back</span>
        </a>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm overflow-hidden border border-gray-100 max-w-2xl">
        <div class="p-8">
            <form method="POST" action="{{ route('admin.menu-items.update', $menuItem) }}">
                @csrf
                @method('PATCH')

                <div class="mb-6">
                    <x-input-label for="name" :value="__('Item Name')" />
                    <x-text-input id="name" class="block mt-1 w-full bg-gray-50 border-none rounded-xl py-3 px-4 focus:ring-2 focus:ring-blue-500 shadow-inner" type="text" name="name" :value="old('name', $menuItem->name)" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select id="category_id" name="category_id" class="block mt-1 w-full bg-gray-50 border-none rounded-xl py-3 px-4 focus:ring-2 focus:ring-blue-500 shadow-inner text-gray-700">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $menuItem->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="price" :value="__('Price ($)')" />
                        <x-text-input id="price" class="block mt-1 w-full bg-gray-50 border-none rounded-xl py-3 px-4 focus:ring-2 focus:ring-blue-500 shadow-inner" type="number" step="0.01" name="price" :value="old('price', $menuItem->price)" required />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>
                </div>

                <div class="mb-6">
                    <x-input-label for="stock" :value="__('Stock Quantity')" />
                    <x-text-input id="stock" class="block mt-1 w-full bg-gray-50 border-none rounded-xl py-3 px-4 focus:ring-2 focus:ring-blue-500 shadow-inner" type="number" name="stock" :value="old('stock', $menuItem->stock)" required />
                    <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <x-input-label for="image" :value="__('Image URL')" />
                    <x-text-input id="image" class="block mt-1 w-full bg-gray-50 border-none rounded-xl py-3 px-4 focus:ring-2 focus:ring-blue-500 shadow-inner" type="url" name="image" :value="old('image', $menuItem->image)" />
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-8">
                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-blue-200 active:scale-95 transition">
                        {{ __('Update Menu Item') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>