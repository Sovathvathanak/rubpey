@extends('layouts.app')

@section('title', 'Transfer Successful')
@section('page-title', 'RubPey Management')

@section('content')
    <div class="card mx-auto max-w-3xl p-10 text-center">
        <span class="relative mx-auto mb-6 inline-flex">
            <span class="absolute inset-0 -m-3 rounded-full bg-emerald-100/60 blur-md"></span>
            <span class="relative flex h-16 w-16 items-center justify-center rounded-full bg-emerald-500 text-white shadow-lg">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
            </span>
        </span>

        <h2 class="text-3xl font-bold text-navy-900">Transfer Completed Successfully</h2>
        <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
            Your funds have been securely moved. A confirmation receipt has been generated for your records.
        </p>

        <div class="mt-8 grid grid-cols-1 gap-4 text-left md:grid-cols-2">
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-5 py-4">
                <span class="text-xs text-slate-500">Transaction Reference</span>
                <p class="mt-1 font-mono text-sm font-bold text-brand-700">{{ $result['reference_code'] }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-5 py-4">
                <span class="text-xs text-slate-500">Timestamp</span>
                <p class="mt-1 font-mono text-sm font-semibold text-slate-900">{{ \Carbon\Carbon::parse($result['transfer_date'])->format('M d, Y · H:i:s') }}</p>
            </div>
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4">
                <span class="text-xs font-semibold uppercase tracking-wider text-emerald-600">Amount Transferred</span>
                <p class="amount mt-1 text-2xl text-emerald-800">{{ $result['from']['currency'] === 'KHR' ? '៛' : '$' }}{{ number_format($result['amount'], 2) }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-5 py-4">
                <span class="text-xs text-slate-500">New Account Balance</span>
                <p class="amount mt-1 text-2xl text-slate-900">{{ $result['from']['currency'] === 'KHR' ? '៛' : '$' }}{{ number_format($result['new_balance'], 2) }}</p>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-center gap-4">
            <a href="{{ route('dashboard') }}" class="btn-navy">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" /></svg>
                Return to Dashboard
            </a>
            <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600 hover:text-brand-700">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                View History
            </a>
        </div>
    </div>
@endsection
