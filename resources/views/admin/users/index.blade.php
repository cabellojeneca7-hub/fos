<x-app-layout>
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Cashier Management</h1>
            <p class="text-gray-500">Manage your staff and cashier accounts.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-blue-200 flex items-center space-x-2 active:scale-95 transition">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            <span>Add Cashier</span>
        </a>
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
                        <th class="pb-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Name</th>
                        <th class="pb-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="pb-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Joined</th>
                        <th class="pb-6 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($cashiers as $cashier)
                        <tr class="group hover:bg-gray-50 transition duration-150">
                            <td class="py-6 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold border-2 border-white shadow-sm">
                                        {{ substr($cashier->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-semibold text-gray-800">{{ $cashier->name }}</span>
                                </div>
                            </td>
                            <td class="py-6 whitespace-nowrap text-sm text-gray-500 font-medium italic">{{ $cashier->email }}</td>
                            <td class="py-6 whitespace-nowrap text-sm text-gray-500">{{ $cashier->created_at->toFormattedDateString() }}</td>
                            <td class="py-6 whitespace-nowrap text-right space-x-2">
                                <a href="{{ route('admin.users.edit', $cashier) }}" class="text-gray-400 hover:text-blue-600 transition inline-block">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.users.destroy', $cashier) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition" onclick="return confirm('Are you sure you want to delete this cashier?')">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-500 italic font-medium">No cashiers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>