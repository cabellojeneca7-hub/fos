<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <style>
            body { background-color: #f1f5f9; }
            .sidebar { background-color: #1e3a8a; }
            .content-area { border-radius: 30px 0 0 0; }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <aside class="w-64 sidebar hidden md:flex flex-col text-white transition-all duration-300 sticky top-0 h-screen">
                <div class="p-6">
                    <div class="flex items-center space-x-3 mb-10">
                        <div class="bg-white p-2 rounded-lg">
                            <svg class="h-8 w-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </div>
                        <span class="text-2xl font-bold tracking-wider uppercase">Food Court</span>
                    </div>
                    
                    <nav class="space-y-4">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 p-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-white/10' : 'hover:bg-white/5' }} transition">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('menu.index') }}" class="flex items-center space-x-3 p-3 rounded-xl {{ request()->routeIs('menu.*') ? 'bg-white/10' : 'hover:bg-white/5' }} transition">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            <span>Menu</span>
                        </a>
                        <a href="{{ route('orders.index') }}" class="flex items-center space-x-3 p-3 rounded-xl {{ request()->routeIs('orders.*') ? 'bg-white/10' : 'hover:bg-white/5' }} transition">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            <span>Orders</span>
                        </a>
                        @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.menu-items.index') }}" class="flex items-center space-x-3 p-3 rounded-xl {{ request()->routeIs('admin.menu-items.*') ? 'bg-white/10' : 'hover:bg-white/5' }} transition">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            <span>Manage Menu</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 p-3 rounded-xl {{ request()->routeIs('admin.users.*') ? 'bg-white/10' : 'hover:bg-white/5' }} transition">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 15.292m1.147-14.945a5 5 0 110 14.59m-1.147-14.945A3 3 0 0011 8.122m-1.147-1.493a3 3 0 011.147-1.493m0 0a5 5 0 014.472 4.472m-4.472-4.472a5 5 0 00-4.472 4.472M4.354 12a4 4 0 1115.292 0m-15.292 0a5 5 0 0114.59 0m-14.59 0A3 3 0 008.122 11m1.493-1.147a3 3 0 011.493 1.147m0 0a5 5 0 01-4.472 4.472m4.472-4.472a5 5 0 004.472 4.472"></path></svg>
                            <span>Employees</span>
                        </a>
                        @endif
                    </nav>
                </div>

                <div class="mt-auto p-6 border-t border-white/10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center space-x-3 p-3 w-full text-left rounded-xl hover:bg-red-500 transition group">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 flex flex-col min-w-0">
                <!-- Topbar -->
                <header class="h-16 flex items-center justify-between px-8 bg-transparent">
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-400">Application</span>
                        <span class="text-gray-400">></span>
                        <span class="text-gray-600 font-medium">Dashboard</span>
                    </div>

                    <div class="flex items-center space-x-6">
                        <div class="flex items-center space-x-3">
                            <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold border-2 border-white shadow-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content Area -->
                <div class="flex-1 bg-[#f1f5f9] px-8 py-6 content-area overflow-y-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>