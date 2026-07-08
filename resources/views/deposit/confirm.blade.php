@extends('layouts.app')

@section('title', 'Confirm Deposit')
@section('page-title', 'RubPey')

@section('content')
    <div class="mx-auto max-w-2xl space-y-6">
        <div class="card p-8">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-navy-900">Confirm Your Deposit</h2>
                    <p class="mt-1 text-sm text-slate-500">Review the transaction details before finalizing the deposit.</p>
                </div>
                <span class="pill-gray shrink-0">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" /></svg>
                    Secure Deposit
                </span>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <span class="stat-label">Funding Source</span>
                    <div class="mt-2 flex items-center gap-3 rounded-lg bg-slate-100 px-4 py-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-brand-600 shadow-sm">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" /></svg>
                        </span>
                        <span>
                            <span class="block text-sm font-bold text-slate-900">External Source</span>
                            <span class="text-xs text-slate-500">Cash / linked account</span>
                        </span>
                    </div>
                </div>
                <div>
                    <span class="stat-label">Destination Account</span>
                    <div class="mt-2 flex items-center gap-3 rounded-lg bg-slate-100 px-4 py-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-navy-800 text-white">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" /></svg>
                        </span>
                        <span>
                            <span class="block text-sm font-bold text-slate-900">{{ $account['account_name'] }}</span>
                            <span class="font-mono text-xs text-slate-500">{{ $account['account_number'] }}</span>
                        </span>
                    </div>
                </div>
                <div>
                    <span class="stat-label">Frequency</span>
                    <p class="mt-1 text-sm font-medium text-slate-900">One-time Deposit</p>
                </div>
                <div>
                    <span class="stat-label">Settlement</span>
                    <p class="mt-1 text-sm font-medium text-slate-900">Instant (available immediately)</p>
                </div>
            </div>

            <div class="mt-8 text-center">
                <span class="stat-label">Deposit Amount</span>
                <p class="amount mt-1 text-4xl text-slate-900">{{ $account['currency'] === 'KHR' ? '៛' : '$' }}{{ number_format($amount, 2) }}</p>
            </div>

            <div class="mt-6 space-y-2.5 rounded-xl bg-slate-100 px-6 py-5">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-600">Subtotal Deposit</span>
                    <span class="amount text-slate-900">{{ $account['currency'] === 'KHR' ? '៛' : '$' }}{{ number_format($amount, 2) }}</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-600">Processing Fee</span>
                    <span class="amount text-slate-900">$0.00</span>
                </div>
                <div class="flex items-center justify-between border-t border-slate-300/70 pt-2.5">
                    <span class="text-sm font-bold text-slate-900">Total to Deposit</span>
                    <span class="amount text-xl text-brand-700">{{ $account['currency'] === 'KHR' ? '៛' : '$' }}{{ number_format($amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="card space-y-3 p-6">
            <form method="POST" action="{{ route('deposit.confirm') }}">
                @csrf
                <button type="submit" class="btn-navy w-full py-3.5">Confirm & Deposit</button>
            </form>
            <a href="{{ route('deposit.index') }}" class="btn-outline-brand w-full py-3.5">Back to Edit</a>
        </div>
    </div>
@endsection
