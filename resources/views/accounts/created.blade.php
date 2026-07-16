@extends('layouts.app')

@section('title', 'Account Created')
@section('page-title', 'Account')

@section('content')
    <div class="relative mx-auto max-w-2xl overflow-hidden rounded-2xl bg-gradient-to-br from-navy-900 via-navy-800 to-navy-700 p-8 shadow-lg">
        <div class="pointer-events-none absolute -right-16 -top-16 h-56 w-56 rounded-full bg-brand-500/20 blur-2xl"></div>
        <span class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
        </span>

        <h2 class="mt-5 text-3xl font-bold leading-tight text-white">Account Created<br>Successfully</h2>
        <p class="mt-3 max-w-xs text-sm text-slate-400">Your financial journey with RubPey starts today.</p>

        <div class="mt-8 rounded-xl bg-navy-800 p-6">
            <div class="flex items-start justify-between">
                <div class="space-y-4">
                    <div>
                        <span class="stat-label !text-slate-400">New Account Type</span>
                        <p class="mt-0.5 text-lg font-bold text-white">{{ $account['account_type'] }}</p>
                    </div>
                    <div>
                        <span class="stat-label !text-slate-400">Account Name</span>
                        <p class="mt-0.5 font-mono text-sm text-white">{{ $account['account_name'] }}</p>
                    </div>
                    <div>
                        <span class="stat-label !text-slate-400">Account Number</span>
                        <p class="mt-0.5 font-mono text-sm tracking-wider text-white">{{ $account['account_number'] }}</p>
                    </div>
                    <div>
                        <span class="stat-label !text-slate-400">Starting Balance</span>
                        <p class="amount mt-0.5 text-sm text-white">{{ $account['currency'] === 'KHR' ? '៛' : '$' }}{{ number_format($account['balance'], 2) }}</p>
                    </div>
                </div>
                <svg class="h-6 w-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" /></svg>
            </div>
        </div>

        <a href="{{ route('accounts.show', $account['account_id']) }}" class="btn mt-6 w-full bg-white py-3 text-xs font-bold text-navy-900 hover:bg-slate-100">
            Go to Account
        </a>
    </div>
@endsection
