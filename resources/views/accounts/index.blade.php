@extends('layouts.app')

@section('title', 'Accounts')
@section('page-title', 'RubPey')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-navy-900 sm:text-3xl">Your Bank Accounts</h2>
            <p class="mt-1 text-sm text-slate-500">Manage your accounts and track their balances.</p>
        </div>
        <a href="{{ route('accounts.create') }}" class="btn-primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Create New Account
        </a>
    </div>

    {{-- Stats --}}
    <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="card p-6">
            <div class="flex items-start justify-between">
                <span class="stat-label">Total Balance</span>
                <span class="icon-tile h-9 w-9">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" /></svg>
                </span>
            </div>
            <p class="amount mt-1 text-3xl text-slate-900">${{ number_format($totalBalance, 2) }}</p>
        </div>
        <div class="card p-6">
            <div class="flex items-start justify-between">
                <span class="stat-label">Active Accounts</span>
                <span class="icon-tile h-9 w-9">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" /></svg>
                </span>
            </div>
            <p class="mt-1 text-3xl font-bold text-slate-900">{{ $activeCount }}</p>
            <p class="mt-1 text-sm text-slate-500">All accounts healthy</p>
        </div>
        <div class="card p-6">
            <div class="flex items-start justify-between">
                <span class="stat-label">Spending</span>
                <span class="icon-tile h-9 w-9">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" /></svg>
                </span>
            </div>
            <p class="amount mt-1 text-3xl text-slate-900">${{ number_format($spending, 2) }}</p>
            <p class="mt-1 text-sm text-slate-500">Completed outgoing transfers</p>
        </div>
    </div>

    {{-- Accounts table --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px]">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="th">Account Name</th>
                        <th class="th">Account Number</th>
                        <th class="th">Account Type</th>
                        <th class="th text-right">Balance</th>
                        <th class="th">Status</th>
                        <th class="th text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($accounts as $account)
                        <tr class="transition hover:bg-slate-50/70">
                            <td class="td">
                                <span class="flex items-center gap-3">
                                    <span class="icon-tile h-9 w-9 {{ $account['account_type'] === 'Savings' ? '!bg-emerald-100 !text-emerald-600' : '' }}">
                                        @if ($account['account_type'] === 'Savings')
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" /></svg>
                                        @else
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" /></svg>
                                        @endif
                                    </span>
                                    <span>
                                        <span class="block font-bold text-navy-900">{{ $account['account_name'] }}</span>
                                        <span class="text-xs text-slate-400">{{ $account['account_type'] }} · {{ $account['currency'] }}</span>
                                    </span>
                                </span>
                            </td>
                            <td class="td font-mono text-xs">{{ $account['account_number'] }}</td>
                            <td class="td">
                                <span class="{{ $account['account_type'] === 'Savings' ? 'pill-green' : 'pill-blue' }}">{{ strtoupper($account['account_type']) }}</span>
                            </td>
                            <td class="td amount text-right">{{ $account['currency'] === 'KHR' ? '៛' : '$' }}{{ number_format($account['balance'], 2) }}</td>
                            <td class="td">@include('partials.status-pill', ['status' => $account['status']])</td>
                            <td class="td text-right">
                                <a href="{{ route('accounts.show', $account['account_id']) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-brand-500 hover:text-brand-600" title="View">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" /></svg>
                                    </span>
                                    No accounts yet — create your first one.
                                    <a href="{{ route('accounts.create') }}" class="btn-primary mt-1">Open an Account</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 bg-slate-50 px-6 py-3 text-sm text-slate-500">
            Showing {{ count($accounts) }} of {{ count($accounts) }} accounts
        </div>
    </div>
@endsection
