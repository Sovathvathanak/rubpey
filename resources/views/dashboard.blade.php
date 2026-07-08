@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="space-y-6 xl:col-span-2">
            {{-- Welcome banner --}}
            <div class="relative overflow-hidden rounded-xl bg-navy-800 px-8 py-10 shadow-lg">
                <div class="pointer-events-none absolute -right-16 -top-16 h-56 w-56 rounded-full bg-brand-500/15 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-20 right-24 h-40 w-40 rounded-full bg-cyan-400/10 blur-2xl"></div>
                <h2 class="relative text-3xl font-bold text-white">Welcome back, {{ $customer['first_name'] }} {{ $customer['last_name'] }}</h2>
                <p class="relative mt-2 text-sm text-slate-400">Here's an overview of your accounts. Ready for your next move?</p>
            </div>

            {{-- Stat cards --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="card p-6">
                    <span class="stat-label">Total Balance</span>
                    <p class="amount mt-3 text-3xl text-slate-900">${{ number_format($totalBalance, 2) }}</p>
                </div>
                <div class="card p-6">
                    <span class="stat-label">Active Accounts</span>
                    <p class="mt-3 text-3xl font-bold text-slate-900">{{ $activeCount }}</p>
                    @if ($accountTypes)
                        <p class="mt-2 flex items-center gap-1.5 text-sm text-slate-500">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" /></svg>
                            {{ $accountTypes }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Quick actions --}}
            <div class="grid grid-cols-3 gap-6">
                <a href="{{ route('accounts.create') }}" class="card flex flex-col items-center gap-3 p-6 transition hover:border-brand-500 hover:shadow-md">
                    <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-brand-100 text-brand-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    </span>
                    <span class="text-xs font-bold text-slate-700">New Account</span>
                </a>
                <a href="{{ route('transfers.initiate') }}" class="card flex flex-col items-center gap-3 p-6 transition hover:border-brand-500 hover:shadow-md">
                    <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-brand-100 text-brand-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" /></svg>
                    </span>
                    <span class="text-xs font-bold text-slate-700">Transfer Money</span>
                </a>
                <a href="{{ route('transactions.index') }}" class="card flex flex-col items-center gap-3 p-6 transition hover:border-brand-500 hover:shadow-md">
                    <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-brand-100 text-brand-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    </span>
                    <span class="text-xs font-bold text-slate-700">View History</span>
                </a>
            </div>

            {{-- Recent transactions --}}
            <div class="card overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4">
                    <h3 class="text-base font-bold text-navy-900">Recent Transactions</h3>
                    <a href="{{ route('transactions.index') }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700">View All</a>
                </div>
                <table class="w-full">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="th">Date</th>
                            <th class="th">Description</th>
                            <th class="th">Status</th>
                            <th class="th text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($recentTransactions as $tx)
                            @php $acct = $accountsById[$tx['account_id']] ?? null; @endphp
                            <tr>
                                <td class="td font-mono text-xs">{{ \Carbon\Carbon::parse($tx['transfer_date'])->format('M d, Y') }}</td>
                                <td class="td font-medium text-slate-900">{{ $tx['description'] }}</td>
                                <td class="td">@include('partials.status-pill', ['status' => $tx['status']])</td>
                                <td class="td amount text-right {{ $tx['amount'] < 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                    {{ $tx['amount'] < 0 ? '-' : '+' }}{{ $acct && $acct['currency'] === 'KHR' ? '៛' : '$' }}{{ number_format(abs($tx['amount']), 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="td py-10 text-center text-slate-400">No transactions yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Profile card --}}
        <div>
            <div class="card p-6 text-center">
                <span class="relative mx-auto mt-4 inline-block">
                    <span class="flex h-20 w-20 items-center justify-center rounded-full border-4 border-slate-100 bg-white text-brand-600 shadow">
                        <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                    </span>
                    <span class="absolute bottom-1 right-1 h-3.5 w-3.5 rounded-full border-2 border-white bg-emerald-500"></span>
                </span>

                <h3 class="mt-4 text-lg font-bold text-navy-900">{{ $customer['first_name'] }} {{ $customer['last_name'] }}</h3>
                <p class="text-sm text-slate-500">Account Holder</p>

                <dl class="mt-6 space-y-3 border-t border-slate-100 pt-5 text-left">
                    <div class="flex items-center justify-between">
                        <dt class="text-xs font-medium text-slate-500">Last Login</dt>
                        <dd class="font-mono text-xs font-semibold text-slate-900">{{ \Carbon\Carbon::parse($customer['last_login'])->format('M d, h:i A') }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-xs font-medium text-slate-500">ID</dt>
                        <dd class="font-mono text-xs font-semibold text-brand-700">{{ $customer['customer_code'] }}</dd>
                    </div>
                </dl>

                <a href="{{ route('settings.index') }}" class="btn-outline-brand mt-6 w-full">Edit Profile Details</a>
            </div>
        </div>
    </div>
@endsection
