<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RubPey · The Currency of Trust</title>
    <link rel="icon" type="image/png" href="{{ asset('images/rubpey-icon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|jetbrains-mono:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-bg min-h-screen font-sans antialiased">
    <div class="flex min-h-screen flex-col">
        <div class="flex flex-1 flex-col items-center justify-center px-6 py-12">
            {{-- Logo --}}
            <img src="{{ asset('images/rubpey-icon.png') }}" alt="RubPey"
                 class="fade-up h-28 w-auto drop-shadow-[0_20px_40px_rgba(6,182,212,0.35)]">

            <h1 class="fade-up mt-5 text-4xl font-extrabold tracking-tight text-white" style="animation-delay: .1s">RubPey</h1>
            <p class="fade-up mt-2 text-base text-[#93c5fd]" style="animation-delay: .18s">The Currency of Trust, The Future of Banking.</p>

            <div class="fade-up mt-10 w-full max-w-md space-y-3" style="animation-delay: .26s">
                <a href="{{ route('login') }}"
                   class="group flex h-[52px] w-full items-center justify-center gap-2 rounded-[14px] bg-brand-600 text-base font-semibold text-white shadow-lg shadow-brand-600/30 transition hover:-translate-y-0.5 hover:bg-brand-500 hover:shadow-xl hover:shadow-brand-600/40">
                    Sign In to Your Account
                    <svg class="h-[18px] w-[18px] transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </a>
                <a href="{{ route('register') }}"
                   class="flex h-[52px] w-full items-center justify-center rounded-[14px] border border-white/20 bg-white/10 text-base font-semibold text-white backdrop-blur-sm transition hover:-translate-y-0.5 hover:border-white/30 hover:bg-white/15">
                    Create New Account
                </a>
            </div>

            <div class="fade-up mt-12 flex items-center gap-8 text-white/40" style="animation-delay: .34s">
                <span class="flex items-center gap-1.5 text-xs">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" /></svg>
                    Bank-grade security
                </span>
                <span class="flex items-center gap-1.5 text-xs">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" /></svg>
                    Instant transfers
                </span>
                <span class="flex items-center gap-1.5 text-xs">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    24/7 access
                </span>
            </div>
        </div>

        <p class="pb-6 text-center text-xs text-white/30">© {{ date('Y') }} RubPey · Banking Management System Prototype</p>
    </div>
</body>
</html>
