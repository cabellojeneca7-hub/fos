<x-app-layout>
    <div x-data="{
        categories: {{ $categories->toJson() }},
        searchQuery: '',
        selectedCategory: 'all',
        maxPrice: 1000,
        adding: null,
        message: null,
        
        get filteredCategories() {
            return this.categories.map(category => {
                return {
                    ...category,
                    menu_items: category.menu_items.map(item => {
                        // Calculate average rating
                        const ratings = item.reviews || [];
                        const avg = ratings.length ? (ratings.reduce((acc, r) => acc + r.rating, 0) / ratings.length).toFixed(1) : 0;
                        return { ...item, avgRating: avg, totalReviews: ratings.length };
                    }).filter(item => {
                        const matchesSearch = item.name.toLowerCase().includes(this.searchQuery.toLowerCase());
                        const matchesCategory = this.selectedCategory === 'all' || category.id == this.selectedCategory;
                        const matchesPrice = item.price <= this.maxPrice;
                        return matchesSearch && matchesCategory && matchesPrice;
                    })
                };
            }).filter(category => category.menu_items.length > 0);
        },

        async addToCart(itemId) {
            this.adding = itemId;
            try {
                const response = await fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        menu_item_id: itemId,
                        quantity: 1
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.message = { type: 'success', text: data.message, itemId: itemId };
                    window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: data.cartCount } }));
                } else {
                    this.message = { type: 'error', text: data.message, itemId: itemId };
                }
            } catch (error) {
                this.message = { type: 'error', text: 'Something went wrong!', itemId: itemId };
            } finally {
                this.adding = null;
                setTimeout(() => { if(this.message?.itemId === itemId) this.message = null; }, 3000);
            }
        }
    }" class="pb-20">
        
        <!-- Header & Filters -->
        <div class="mb-12 space-y-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Interactive Menu</h1>
                    <p class="text-gray-500 mt-1">Discover our delicious items and add them to your cart instantly.</p>
                </div>
                
                <div class="flex flex-wrap items-center gap-3">
                    <div class="relative group">
                        <input type="text" x-model="searchQuery" placeholder="Search deliciousness..." 
                               class="bg-white border-none rounded-2xl py-3 px-5 pr-12 shadow-sm focus:ring-2 focus:ring-blue-500 w-full md:w-72 text-sm transition-all duration-300 group-hover:shadow-md">
                        <div class="absolute right-4 top-3.5 text-gray-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-6 bg-white p-6 rounded-[2rem] shadow-sm border border-gray-50">
                <div class="flex flex-col space-y-2">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Category</label>
                    <select x-model="selectedCategory" class="bg-gray-50 border-none rounded-xl py-2 px-4 text-sm focus:ring-2 focus:ring-blue-500 shadow-inner min-w-[150px]">
                        <option value="all">All Categories</option>
                        <template x-for="cat in categories" :key="cat.id">
                            <option :value="cat.id" x-text="cat.name"></option>
                        </template>
                    </select>
                </div>

                <div class="flex-1 min-w-[200px] flex flex-col space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Max Price</label>
                        <span class="text-sm font-bold text-blue-600" x-text="'₱' + maxPrice"></span>
                    </div>
                    <input type="range" x-model="maxPrice" min="0" max="2000" step="10" 
                           class="w-full h-2 bg-gray-100 rounded-lg appearance-none cursor-pointer accent-blue-600">
                </div>
            </div>
        </div>

        <!-- Notification Toast -->
        <template x-if="message && !message.itemId">
            <div x-transition class="fixed bottom-8 right-8 z-50 flex items-center space-x-3 px-6 py-4 rounded-2xl shadow-2xl text-white"
                 :class="message.type === 'success' ? 'bg-blue-600' : 'bg-red-600'">
                <svg x-show="message.type === 'success'" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <svg x-show="message.type === 'error'" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-bold" x-text="message.text"></span>
            </div>
        </template>

        <!-- Menu Display -->
        <div class="space-y-16">
            <template x-for="category in filteredCategories" :key="category.id">
                <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                    <div class="flex items-center mb-8">
                        <div class="w-2 h-10 bg-blue-600 rounded-full mr-4 shadow-lg shadow-blue-200"></div>
                        <h3 class="text-2xl font-bold text-gray-800" x-text="category.name"></h3>
                        <div class="ml-4 flex-1 h-[1px] bg-gray-100"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                        <template x-for="item in category.menu_items" :key="item.id">
                            <div class="bg-white rounded-[2.5rem] p-6 shadow-sm hover:shadow-2xl transition-all duration-500 border border-transparent hover:border-blue-50 group flex flex-col"
                                 :class="item.stock <= 0 ? 'opacity-80' : ''">
                                
                                <div class="aspect-square bg-gray-50 rounded-[2rem] mb-6 flex items-center justify-center relative overflow-hidden">
                                    <template x-if="item.image">
                                        <img :src="item.image" :alt="item.name" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                    </template>
                                    <template x-if="!item.image">
                                        <svg class="h-20 w-20 text-gray-200 group-hover:scale-110 transition duration-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </template>
                                    
                                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl text-blue-600 font-black text-sm shadow-sm border border-white/50">
                                        ₱<span x-text="Number(item.price).toLocaleString(undefined, {minimumFractionDigits: 2})"></span>
                                    </div>

                                    <!-- Out of Stock Overlay -->
                                    <template x-if="item.stock <= 0">
                                        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-[2px] flex items-center justify-center">
                                            <span class="bg-white/90 text-gray-900 px-6 py-2 rounded-full font-black text-xs uppercase tracking-widest shadow-xl">Out of Stock</span>
                                        </div>
                                    </template>
                                </div>

                                <div class="flex items-center justify-between mb-2 px-2">
                                    <h4 class="font-bold text-xl text-gray-800" x-text="item.name"></h4>
                                    <template x-if="item.totalReviews > 0">
                                        <div class="flex items-center space-x-1 text-yellow-500">
                                            <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            <span class="text-xs font-black" x-text="item.avgRating"></span>
                                        </div>
                                    </template>
                                </div>
                                
                                <div class="mt-auto pt-4" x-data="{ showRate: false }">
                                    <template x-if="item.stock > 0">
                                        <div class="space-y-4">
                                            <!-- Review Form Toggle -->
                                            <div x-show="showRate" x-transition class="bg-gray-50 p-4 rounded-2xl mb-4 border border-gray-100">
                                                <form :action="'/menu-items/' + item.id + '/reviews'" method="POST">
                                                    @csrf
                                                    <div class="flex justify-between items-center mb-3">
                                                        <label class="text-[10px] font-black uppercase text-gray-400">Rate it</label>
                                                        <div class="flex space-x-1">
                                                            <template x-for="i in 5">
                                                                <button type="button" @click="$root.querySelector('input[name=rating]').value = i" class="text-gray-300 hover:text-yellow-400 transition">
                                                                    <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                                </button>
                                                            </template>
                                                        </div>
                                                        <input type="hidden" name="rating" value="5">
                                                    </div>
                                                    <textarea name="comment" placeholder="Any thoughts?" class="w-full text-xs bg-white border-none rounded-xl p-3 focus:ring-1 focus:ring-blue-500 shadow-inner mb-3" rows="2"></textarea>
                                                    <div class="flex space-x-2">
                                                        <button type="submit" class="flex-1 bg-gray-800 text-white text-[10px] font-black py-2 rounded-lg">Submit</button>
                                                        <button type="button" @click="showRate = false" class="px-3 bg-white text-gray-400 text-[10px] font-black py-2 rounded-lg border border-gray-100">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="flex space-x-2">
                                                <button @click="addToCart(item.id)" 
                                                        :disabled="adding === item.id"
                                                        class="flex-1 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-bold py-4 px-6 rounded-2xl transition-all duration-300 shadow-xl shadow-blue-100 active:scale-95 flex items-center justify-center space-x-2">
                                                    
                                                    <template x-if="adding !== item.id && (!message || message.itemId !== item.id || message.type !== 'success')">
                                                        <div class="flex items-center space-x-2">
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                            <span>Add</span>
                                                        </div>
                                                    </template>

                                                    <template x-if="adding === item.id">
                                                        <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                    </template>

                                                    <template x-if="message && message.itemId === item.id && message.type === 'success'">
                                                        <div class="flex items-center space-x-2">
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                            <span>Added!</span>
                                                        </div>
                                                    </template>
                                                </button>
                                                <button @click="showRate = !showRate" class="px-4 bg-white border border-gray-100 rounded-2xl text-gray-400 hover:text-yellow-500 hover:border-yellow-100 transition shadow-sm">
                                                    <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                </button>
                                            </div>
                                            <div class="text-center">
                                                <span class="text-[10px] font-black uppercase tracking-tighter" :class="item.stock < 10 ? 'text-red-500' : 'text-gray-300'">
                                                    Stock: <span x-text="item.stock"></span> Available
                                                </span>
                                            </div>
                                        </div>
                                    </template>

                                    <template x-if="item.stock <= 0">
                                        <button disabled class="w-full bg-gray-100 text-gray-400 font-bold py-4 px-6 rounded-2xl cursor-not-allowed">
                                            Unavailable
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        <!-- Empty State -->
        <template x-if="filteredCategories.length === 0">
            <div class="bg-white rounded-[3rem] p-20 text-center shadow-sm border border-gray-100 mt-10">
                <div class="bg-gray-50 h-24 w-24 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">No items found</h3>
                <p class="text-gray-500 mt-2">Try adjusting your search or filters to find what you're looking for.</p>
                <button @click="searchQuery = ''; selectedCategory = 'all'; maxPrice = 2000" class="mt-8 text-blue-600 font-bold hover:underline">Clear all filters</button>
            </div>
        </template>
    </div>
</x-app-layout>
