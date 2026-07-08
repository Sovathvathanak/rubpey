@extends('layouts.auth')

@section('title', 'Sign in')

@section('card')
    <div class="p-8">
        <h1 class="mb-6 text-xl font-bold text-slate-900">Sign in</h1>

        @if (session('status'))
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf
            <div>
                <label for="national_id" class="label">ID Number</label>
                <input id="national_id" name="national_id" type="text" value="{{ old('national_id') }}" placeholder="000000000" class="input" required autofocus>
            </div>
            <div>
                <label for="pin" class="label">PIN-Number</label>
                <input id="pin" name="pin" type="password" placeholder="••••••••" class="input" required>
            </div>
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-xs text-slate-600">
                    <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500" checked>
                    Remember me
                </label>
                <a href="{{ route('password.forgot') }}" class="text-xs font-medium text-brand-600 hover:text-brand-700">Forgot password?</a>
            </div>
            <button type="submit" class="btn-primary w-full rounded-full py-3">Sign In</button>
        </form>

        <p class="mt-6 text-center text-xs text-slate-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-sm font-bold text-brand-600 hover:text-brand-700">Create one</a>
        </p>

        <p class="mt-4 rounded-lg bg-slate-50 px-3 py-2 text-center text-xs text-slate-400">
            Demo: ID <span class="font-mono">001122334</span> · PIN <span class="font-mono">123456</span>
        </p>
    </div>
@endsection
