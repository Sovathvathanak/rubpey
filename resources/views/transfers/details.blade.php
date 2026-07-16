@extends('layouts.app')

@section('title', 'Transfer Details')
@section('page-title', 'Transfer Funds')

@section('content')
    <nav class="mb-4 text-sm text-slate-500">
        <a href="{{ route('transfers.initiate') }}" class="hover:text-navy-900">Transfers</a>
        <span class="mx-1.5">›</span>
        <span class="font-semibold text-navy-900">New Domestic Transfer</span>
    </nav>

    @include('partials.transfer-steps', ['current' => 2])

    <div class="card mx-auto max-w-3xl overflow-hidden">
        <div class="border-b border-slate-200 bg-slate-50 px-8 py-5">
            <h2 class="text-lg font-bold text-navy-900">Transfer Details</h2>
            <p class="text-xs text-slate-500">Enter the recipient information and the amount you wish to send.</p>
        </div>

        <form method="POST" action="{{ route('transfers.details.post') }}" class="p-8">
            @csrf
            {{-- Source summary --}}
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-brand-100 bg-brand-50/50 px-5 py-4">
                <div>
                    <span class="stat-label">Source Account</span>
                    <p class="mt-0.5 text-sm font-semibold text-navy-900">{{ $source['account_name'] }}</p>
                    <p class="font-mono text-xs text-slate-500">{{ $source['account_number'] }}</p>
                </div>
                <div class="text-right">
                    <span class="stat-label">Available Balance</span>
                    <p class="amount mt-0.5 text-sm text-slate-900">{{ $source['currency'] === 'KHR' ? '៛' : '$' }}{{ number_format($source['balance'], 2) }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="recipient_account_number" class="label">Recipient Account Number</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" /></svg>
                        </span>
                        <input id="recipient_account_number" name="recipient_account_number" type="text"
                               value="{{ old('recipient_account_number', $data['recipient_account_number'] ?? '') }}"
                               placeholder="Enter account number" class="input pl-9 font-mono" required autofocus>
                    </div>
                    <p class="mt-1 text-xs text-slate-400">e.g. 001-2000001</p>
                    @error('recipient_account_number')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="amount" class="label">Transfer Amount ({{ $source['currency'] === 'KHR' ? '៛' : '$' }})</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" /></svg>
                        </span>
                        <input id="amount" name="amount" type="number" step="0.01" min="0.01"
                               value="{{ old('amount', $data['amount'] ?? '') }}"
                               placeholder="0.00" class="input pl-9 font-mono" required>
                    </div>
                    @error('amount')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mt-5">
                <label for="remark" class="label">Remark</label>
                <textarea id="remark" name="remark" rows="3" placeholder="Add a description for your records (optional)"
                          class="input resize-none">{{ old('remark', $data['remark'] ?? '') }}</textarea>
                @error('remark')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="mt-8 flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                <a href="{{ route('transfers.initiate') }}" class="btn-outline-brand">Cancel</a>
                <button type="submit" class="btn-primary">
                    Review Transfer
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </button>
            </div>
        </form>
    </div>
@endsection
