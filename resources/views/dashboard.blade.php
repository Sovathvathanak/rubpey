@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="space-y-6 xl:col-span-2">
            {{-- Welcome banner --}}
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-navy-900 via-navy-800 to-navy-700 px-6 py-8 shadow-lg sm:px-8 sm:py-10">
                <div class="pointer-events-none absolute -right-16 -top-16 h-56 w-56 rounded-full bg-brand-500/20 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-20 right-24 h-40 w-40 rounded-full bg-cyan-400/10 blur-2xl"></div>
                <p class="relative text-xs font-semibold uppercase tracking-widest text-brand-200/80">{{ now()->format('l, F d, Y') }}</p>
                <h2 class="relative mt-2 text-2xl font-bold text-white sm:text-3xl">Welcome back, {{ $customer['first_name'] }} {{ $customer['last_name'] }}</h2>
                <p class="relative mt-2 text-sm text-slate-400">Here's an overview of your accounts. Ready for your next move?</p>
            </div>

            {{-- Stat cards --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="card p-6">
                    <div class="flex items-start justify-between">
                        <span class="stat-label">Total Balance</span>
                        <span class="icon-tile h-9 w-9">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" /></svg>
                        </span>
                    </div>
                    <p class="amount mt-2 text-3xl text-slate-900">${{ number_format($totalBalance, 2) }}</p>
                    <p class="mt-1 text-sm text-slate-500">Across all your accounts</p>
                </div>
                <div class="card p-6">
                    <div class="flex items-start justify-between">
                        <span class="stat-label">Active Accounts</span>
                        <span class="icon-tile h-9 w-9">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" /></svg>
                        </span>
                    </div>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $activeCount }}</p>
                    @if ($accountTypes)
                        <p class="mt-1 flex items-center gap-1.5 text-sm text-slate-500">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" /></svg>
                            {{ $accountTypes }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Quick actions --}}
            <div class="grid grid-cols-3 gap-3 sm:gap-6">
                <a href="{{ route('accounts.create') }}" class="card group flex flex-col items-center gap-3 p-4 transition hover:-translate-y-0.5 hover:border-brand-500 hover:shadow-md sm:p-6">
                    <span class="icon-tile h-11 w-11 transition group-hover:scale-110">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    </span>
                    <span class="text-center text-xs font-bold text-slate-700 group-hover:text-brand-700">New Account</span>
                </a>
                <a href="{{ route('transfers.initiate') }}" class="card group flex flex-col items-center gap-3 p-4 transition hover:-translate-y-0.5 hover:border-brand-500 hover:shadow-md sm:p-6">
                    <span class="icon-tile h-11 w-11 transition group-hover:scale-110">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" /></svg>
                    </span>
                    <span class="text-center text-xs font-bold text-slate-700 group-hover:text-brand-700">Transfer Money</span>
                </a>
                <a href="{{ route('transactions.index') }}" class="card group flex flex-col items-center gap-3 p-4 transition hover:-translate-y-0.5 hover:border-brand-500 hover:shadow-md sm:p-6">
                    <span class="icon-tile h-11 w-11 transition group-hover:scale-110">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    </span>
                    <span class="text-center text-xs font-bold text-slate-700 group-hover:text-brand-700">View History</span>
                </a>
            </div>

            {{-- Recent transactions --}}
            <div class="card overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4">
                    <h3 class="text-base font-bold text-navy-900">Recent Transactions</h3>
                    <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-brand-600 hover:text-brand-700">
                        View All
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[540px]">
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
                                <tr class="transition hover:bg-slate-50/70">
                                    <td class="td font-mono text-xs">{{ \Carbon\Carbon::parse($tx['transfer_date'])->format('M d, Y') }}</td>
                                    <td class="td font-medium text-slate-900">
                                        <span class="flex items-center gap-3">
                                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full {{ $tx['amount'] < 0 ? 'bg-slate-100 text-slate-600' : 'bg-emerald-100 text-emerald-600' }}">
                                                @if ($tx['amount'] < 0)
                                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" /></svg>
                                                @else
                                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" /></svg>
                                                @endif
                                            </span>
                                            {{ $tx['description'] }}
                                        </span>
                                    </td>
                                    <td class="td">@include('partials.status-pill', ['status' => $tx['status']])</td>
                                    <td class="td amount text-right {{ $tx['amount'] < 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                        {{ $tx['amount'] < 0 ? '-' : '+' }}{{ $acct && $acct['currency'] === 'KHR' ? '៛' : '$' }}{{ number_format(abs($tx['amount']), 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <span class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                            </span>
                                            No transactions yet.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Profile card --}}
        <div>
            <div class="card overflow-hidden text-center">
                <div class="h-20 bg-gradient-to-r from-navy-800 via-navy-700 to-brand-700"></div>
                <div class="-mt-10 px-6 pb-6">
                    <span class="relative inline-block">
                        <span class="flex h-20 w-20 items-center justify-center rounded-full border-4 border-white bg-brand-50 text-2xl font-bold text-brand-600 shadow">
                            {{ strtoupper(mb_substr($customer['first_name'], 0, 1) . mb_substr($customer['last_name'], 0, 1)) }}
                        </span>
                        <span class="absolute bottom-1 right-1 h-3.5 w-3.5 rounded-full border-2 border-white bg-emerald-500"></span>
                    </span>

                    <h3 class="mt-3 text-lg font-bold text-navy-900">{{ $customer['first_name'] }} {{ $customer['last_name'] }}</h3>
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
    </div>
@endsection
