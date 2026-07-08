<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'RubPey') · RubPey</title>
    <link rel="icon" type="image/png" href="{{ asset('images/rubpey-icon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|jetbrains-mono:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-bg min-h-screen font-sans antialiased text-slate-900">
    <div class="flex min-h-screen items-center justify-center p-6">
        <div class="fade-up w-full @yield('card-width', 'max-w-md')">
            <a href="@yield('back-url', route('home'))" class="group mb-4 inline-flex items-center gap-2 text-sm font-medium text-brand-500 transition hover:text-brand-200">
                <svg class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
                @yield('back-label', 'Back to Home')
            </a>
            <div class="rounded-2xl bg-white shadow-2xl shadow-navy-950/60 ring-1 ring-white/10">
                @yield('card')
            </div>
        </div>
    </div>
</body>
</html>
