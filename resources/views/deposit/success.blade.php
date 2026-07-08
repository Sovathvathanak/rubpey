@extends('layouts.app')

@section('title', 'Deposit Successful')
@section('page-title', 'RubPey')

@section('content')
    <div class="card mx-auto max-w-xl p-10 text-center">
        <span class="relative mx-auto mb-6 inline-flex">
            <span class="absolute inset-0 -m-3 rounded-full bg-emerald-100/60 blur-md"></span>
            <span class="relative flex h-16 w-16 items-center justify-center rounded-full border-4 border-emerald-200 bg-emerald-400 text-white shadow-lg">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
            </span>
        </span>

        <h2 class="text-3xl font-bold text-slate-900">Deposit Successful</h2>
        <p class="mx-auto mt-2 max-w-sm text-sm text-slate-500">
            Your funds have been securely deposited and are now available in your designated account.
        </p>

        <div class="mt-8 rounded-xl border border-slate-200 p-6 text-left">
            <span class="border-b border-slate-100 pb-2 text-xs font-bold uppercase tracking-wider text-navy-900">Transaction Details</span>
            <dl class="mt-4 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <dt class="text-sm text-slate-500">Amount</dt>
                    <dd class="amount text-lg text-slate-900">{{ $result['account']['currency'] === 'KHR' ? '៛' : '$' }}{{ number_format($result['amount'], 2) }}</dd>
                </div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <dt class="text-sm text-slate-500">Destination Account</dt>
                    <dd class="text-sm font-semibold text-slate-900">{{ $result['account']['account_name'] }} <span class="font-mono text-xs text-slate-400">{{ $result['account']['account_number'] }}</span></dd>
                </div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <dt class="text-sm text-slate-500">New Balance</dt>
                    <dd class="amount text-sm text-slate-900">{{ $result['account']['currency'] === 'KHR' ? '៛' : '$' }}{{ number_format($result['new_balance'], 2) }}</dd>
                </div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <dt class="text-sm text-slate-500">Reference ID</dt>
                    <dd class="font-mono text-sm font-semibold text-brand-700">{{ $result['reference_code'] }}</dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-sm text-slate-500">Availability</dt>
                    <dd><span class="pill-green">Available Immediately</span></dd>
                </div>
            </dl>
        </div>

        <div class="mt-8 flex items-center justify-center gap-4">
            <a href="{{ route('dashboard') }}" class="btn-navy py-3">Return to Dashboard</a>
            <a href="{{ route('accounts.show', $result['account']['account_id']) }}" class="btn-outline py-3">View Account Details</a>
        </div>
    </div>
@endsection
