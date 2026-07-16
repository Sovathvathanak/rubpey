@extends('layouts.app')

@section('title', $account['account_name'])
@section('page-title', 'Account Details')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <nav class="text-sm text-slate-500">
            <a href="{{ route('accounts.index') }}" class="hover:text-navy-900">Accounts</a>
            <span class="mx-1.5">›</span>
            <span class="font-semibold text-navy-900">{{ $account['account_type'] }} {{ $account['account_number'] }}</span>
        </nav>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('accounts.index') }}" class="btn-outline">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
                Back to List
            </a>
            <form method="POST" action="{{ route('transfers.source') }}">
                @csrf
                <input type="hidden" name="source_account_id" value="{{ $account['account_id'] }}">
                <button type="submit" class="btn-primary">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" /></svg>
                    Transfer from this Account
                </button>
            </form>
        </div>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Balance --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-navy-900 via-navy-800 to-navy-700 p-6 shadow-lg lg:col-span-2">
            <div class="pointer-events-none absolute -right-12 -top-12 h-48 w-48 rounded-full bg-brand-500/20 blur-2xl"></div>
            <div class="pointer-events-none absolute -bottom-16 right-32 h-36 w-36 rounded-full bg-cyan-400/10 blur-2xl"></div>
            <div class="relative flex items-center justify-between">
                <span class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-brand-200/80">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" /></svg>
                    Current Available Balance
                </span>
                <span class="rounded-full bg-white/10 px-2.5 py-1 text-xs font-bold tracking-wider text-white">{{ $account['currency'] }}</span>
            </div>
            <p class="amount relative mt-4 text-4xl text-white sm:text-5xl">{{ $account['currency'] === 'KHR' ? '៛' : '$' }}{{ number_format($account['balance'], 2) }}</p>
            <p class="relative mt-4 font-mono text-sm tracking-widest text-slate-400">{{ $account['account_number'] }}</p>
        </div>

        {{-- Meta --}}
        <div class="card p-6">
            <h3 class="text-lg font-bold text-navy-900">{{ $account['account_name'] }}</h3>
            <dl class="mt-4 space-y-3">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                    <dt class="text-xs text-slate-500">Number</dt>
                    <dd class="font-mono text-xs font-semibold text-slate-900">{{ $account['account_number'] }}</dd>
                </div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                    <dt class="text-xs text-slate-500">Type</dt>
                    <dd class="text-xs font-semibold text-slate-900">{{ $account['account_type'] }}</dd>
                </div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                    <dt class="text-xs text-slate-500">Currency</dt>
                    <dd class="text-xs font-semibold text-slate-900">{{ $account['currency'] }}</dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-xs text-slate-500">Status</dt>
                    <dd>@include('partials.status-pill', ['status' => $account['status']])</dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- Transactions --}}
    <div class="card overflow-hidden">
        <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4">
            <div>
                <h3 class="text-base font-bold text-navy-900">Recent Transactions</h3>
                <p class="text-xs text-slate-500">Latest {{ count($transactions) }} activities for this account</p>
            </div>
            <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-brand-600 hover:text-brand-700">
                View Full History
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[680px]">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="th">Transaction Details</th>
                        <th class="th">ID</th>
                        <th class="th">Date</th>
                        <th class="th">Status</th>
                        <th class="th text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($transactions as $tx)
                        <tr class="transition hover:bg-slate-50/70">
                            <td class="td">
                                <span class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full {{ $tx['amount'] >= 0 ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-600' }}">
                                        @if ($tx['amount'] >= 0)
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" /></svg>
                                        @else
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" /></svg>
                                        @endif
                                    </span>
                                    <span class="font-semibold text-slate-900">{{ $tx['description'] }}</span>
                                </span>
                            </td>
                            <td class="td font-mono text-xs">#TXN-{{ str_pad($tx['transaction_id'], 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="td text-xs">{{ \Carbon\Carbon::parse($tx['transfer_date'])->format('M d, Y') }}</td>
                            <td class="td">@include('partials.status-pill', ['status' => $tx['status']])</td>
                            <td class="td amount text-right {{ $tx['amount'] < 0 ? 'text-slate-900' : 'text-emerald-600' }}">
                                {{ $tx['amount'] < 0 ? '-' : '+' }}{{ $account['currency'] === 'KHR' ? '៛' : '$' }}{{ number_format(abs($tx['amount']), 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                    </span>
                                    No transactions on this account yet.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
