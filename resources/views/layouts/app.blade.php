<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') · RubPey</title>
    <link rel="icon" type="image/png" href="{{ asset('images/rubpey-icon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|jetbrains-mono:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 font-sans antialiased text-slate-900">
    <input type="checkbox" id="sidebar-toggle" class="peer sr-only">

    @include('partials.sidebar')

    {{-- Mobile overlay: tapping it closes the sidebar --}}
    <label for="sidebar-toggle" class="fixed inset-0 z-20 hidden bg-navy-950/50 backdrop-blur-sm peer-checked:block lg:peer-checked:hidden"></label>

    <div class="flex min-h-screen flex-col lg:ml-56">
        <header class="sticky top-0 z-10 flex h-14 items-center justify-between border-b border-slate-200 bg-white/90 px-4 backdrop-blur sm:px-6">
            <div class="flex items-center gap-3">
                <label for="sidebar-toggle" class="-ml-1 flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-navy-900 lg:hidden" title="Menu">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                </label>
                <h1 class="text-lg font-bold text-navy-900">@yield('page-title', 'RubPey')</h1>
            </div>
            <div class="flex items-center gap-1.5 sm:gap-2">
                <a href="{{ route('activity.index') }}" class="relative flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-navy-900" title="Activity">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" /></svg>
                    @if(!empty($unreadActivity))
                        <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                    @endif
                </a>
                <span class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500" title="Help">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" /></svg>
                </span>
                <a href="{{ route('profile.show') }}" class="ml-1 inline-flex h-9 w-9 items-center justify-center rounded-full border-2 border-brand-200 bg-brand-50 text-brand-600 transition hover:border-brand-500 hover:shadow-sm" title="Profile">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                </a>
            </div>
        </header>

        <main class="fade-up flex-1 p-4 sm:p-6 lg:p-8">
            <div class="mx-auto w-full max-w-7xl">
                @if(session('flash_error'))
                    <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                        <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
                        {{ session('flash_error') }}
                    </div>
                @endif
                @if(session('flash_success'))
                    <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                        {{ session('flash_success') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
