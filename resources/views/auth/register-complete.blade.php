@extends('layouts.auth')

@section('title', 'Account Created')
@section('card-width', 'max-w-lg')

@section('card')
    <div class="flex items-center gap-2 px-8 pt-6 pb-4">
        @include('partials.logo', ['class' => 'h-8 w-8'])
        <span class="text-sm font-bold text-slate-900">RubPey</span>
    </div>
    @include('partials.register-progress', ['current' => 4])

    <div class="p-8 text-center">
        <span class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100">
            <svg class="h-7 w-7 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
        </span>

        <h1 class="text-xl font-bold text-slate-900">Account Created!</h1>
        <p class="mx-auto mt-2 max-w-xs text-sm text-slate-500">
            Your bank account has been successfully created. You can now sign in and start managing your finances.
        </p>

        <div class="mt-6 rounded-xl border border-slate-200 bg-slate-50 px-5 py-4 text-left">
            <span class="text-xs text-slate-500">Customer ID</span>
            <span class="mt-0.5 block font-mono text-sm font-bold text-slate-900">{{ $customerCode }}</span>
        </div>

        <form method="POST" action="{{ route('register.finish') }}" class="mt-6">
            @csrf
            <button type="submit" class="btn-primary w-full py-3">
                Go to Dashboard
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
            </button>
        </form>
    </div>
@endsection
