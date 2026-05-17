<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Food Court') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-100 text-slate-900">
    <div class="min-h-screen flex items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
        <div class="w-full max-w-6xl grid lg:grid-cols-2 rounded-[2rem] overflow-hidden border border-slate-200 shadow-sm bg-white">
            <div class="hidden lg:flex bg-blue-900 text-white p-10 flex-col justify-between">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                    <span class="h-12 w-12 rounded-xl bg-white/15 flex items-center justify-center">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </span>
                    <span class="font-bold uppercase tracking-wider text-lg">Food Court</span>
                </a>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-200 mb-3">Welcome Back</p>
                    <h1 class="text-4xl font-extrabold leading-tight">Access your dashboard with the same workflow-ready design.</h1>
                    <p class="text-blue-100 mt-5">Sign in or create an account to manage menu items, orders, and employee access.</p>
                </div>

                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div class="rounded-2xl bg-white/10 px-4 py-3">
                        <p class="text-blue-200">Theme</p>
                        <p class="font-semibold">Dashboard Match</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 px-4 py-3">
                        <p class="text-blue-200">Experience</p>
                        <p class="font-semibold">Fast + Clear</p>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-10 lg:p-12 bg-white">
                <div class="lg:hidden mb-8">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                        <span class="h-10 w-10 rounded-xl bg-blue-900 text-white flex items-center justify-center">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </span>
                        <span class="font-bold uppercase tracking-wider text-slate-800">Food Court</span>
                    </a>
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
