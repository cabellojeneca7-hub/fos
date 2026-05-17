<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Food Court') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-slate-100 text-slate-900 antialiased">
    <div class="min-h-screen">
        <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm px-5 py-4 flex items-center justify-between">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <span class="h-11 w-11 rounded-xl bg-blue-900 text-white flex items-center justify-center">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </span>
                    <div>
                        <p class="text-sm text-slate-500">Ordering System</p>
                        <p class="text-lg font-bold text-slate-800 uppercase tracking-wide">Food Court</p>
                    </div>
                </a>

                <nav class="flex items-center gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-900 text-white font-semibold text-sm hover:bg-blue-800 transition">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 rounded-xl border border-slate-300 text-slate-700 font-semibold text-sm hover:bg-slate-100 transition">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-900 text-white font-semibold text-sm hover:bg-blue-800 transition">Register</a>
                        @endif
                    @endauth
                </nav>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-10">
            <section class="grid lg:grid-cols-5 gap-6 mb-6">
                <div class="lg:col-span-3 bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8 lg:p-10">
                    <p class="inline-flex items-center rounded-full bg-blue-100 text-blue-700 px-3 py-1 text-xs font-bold uppercase tracking-wide mb-5">Fast Ordering Experience</p>
                    <h1 class="text-4xl lg:text-5xl font-extrabold text-slate-800 leading-tight mb-4">Manage menu, orders, and people in one clean dashboard.</h1>
                    <p class="text-slate-500 text-lg mb-8">This platform gives your food court team a central workspace for handling daily operations with speed and clarity.</p>
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="inline-flex items-center px-5 py-3 rounded-2xl bg-blue-900 text-white font-semibold hover:bg-blue-800 transition">
                            {{ auth()->check() ? 'Open Dashboard' : 'Start with Login' }}
                        </a>
                        @guest
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-100 transition">Create Account</a>
                            @endif
                        @endguest
                    </div>
                </div>

                <div class="lg:col-span-2 bg-blue-900 text-white rounded-[2rem] shadow-sm p-8">
                    <h2 class="text-lg font-bold mb-6">Why teams choose this setup</h2>
                    <ul class="space-y-4 text-blue-100 text-sm">
                        <li class="flex items-start gap-3"><span class="mt-0.5 h-2.5 w-2.5 rounded-full bg-blue-300"></span><span>Live summary cards for sales, orders, and product performance.</span></li>
                        <li class="flex items-start gap-3"><span class="mt-0.5 h-2.5 w-2.5 rounded-full bg-blue-300"></span><span>Simple role-based access for admins and staff members.</span></li>
                        <li class="flex items-start gap-3"><span class="mt-0.5 h-2.5 w-2.5 rounded-full bg-blue-300"></span><span>Consistent interface from landing page to authentication and dashboard.</span></li>
                    </ul>
                </div>
            </section>

            <section class="grid md:grid-cols-3 gap-6">
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <div class="h-12 w-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Order Flow</h3>
                    <p class="text-slate-500 text-sm">Track queue and receipts quickly with fewer clicks during peak hours.</p>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <div class="h-12 w-12 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Menu Control</h3>
                    <p class="text-slate-500 text-sm">Update availability, stock, and category placement anytime.</p>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <div class="h-12 w-12 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Team Accounts</h3>
                    <p class="text-slate-500 text-sm">Give each employee proper access with admin-managed roles.</p>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
