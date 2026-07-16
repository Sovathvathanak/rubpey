@extends('layouts.app')

@section('title', 'Transfers')
@section('page-title', 'RubPey Management')

@section('content')
    <h2 class="text-2xl font-bold text-navy-900 sm:text-3xl">Initiate Secure Transfer</h2>
    <p class="mb-6 mt-1 text-sm text-slate-500">Configure your transaction details. All transfers are protected.</p>

    @include('partials.transfer-steps', ['current' => 1])

    @if ($errors->any())
        <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
            <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
            {{ $errors->first() }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Source account --}}
        <div class="card p-6">
            <div class="flex items-start gap-3">
                <span class="icon-tile h-10 w-10">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" /></svg>
                </span>
                <div>
                    <h3 class="text-base font-bold text-navy-900">Source Account</h3>
                    <p class="text-xs text-slate-500">Select where the funds will be debited from</p>
                </div>
            </div>

            <form method="POST" action="{{ route('transfers.source') }}" id="source-form">
                @csrf
                <div class="mt-5 space-y-2.5">
                    @forelse ($accounts as $account)
                        <label class="flex cursor-pointer items-center justify-between rounded-xl border-2 px-4 py-3.5 transition
                            {{ ($source['account_id'] ?? null) === $account['account_id'] ? 'border-brand-500 bg-brand-50 shadow-sm' : 'border-slate-200 bg-white hover:border-brand-300 hover:bg-brand-50/40' }}
                            {{ $account['status'] !== 'Active' ? 'cursor-not-allowed opacity-50' : '' }}">
                            <span class="flex items-center gap-3">
                                <input type="radio" name="source_account_id" value="{{ $account['account_id'] }}"
                                       class="h-4 w-4 border-slate-300 text-brand-600 focus:ring-brand-500"
                                       @checked(($source['account_id'] ?? null) === $account['account_id'])
                                       @disabled($account['status'] !== 'Active')>
                                <span>
                                    <span class="block text-sm font-bold text-slate-900">{{ $account['account_name'] }}</span>
                                    <span class="font-mono text-xs text-slate-400">{{ $account['account_number'] }}</span>
                                </span>
                            </span>
                            <span class="text-right">
                                <span class="amount block text-sm text-slate-900">{{ $account['currency'] === 'KHR' ? '៛' : '$' }}{{ number_format($account['balance'], 2) }}</span>
                                @if ($account['status'] !== 'Active')
                                    <span class="text-xs text-red-500">{{ $account['status'] }}</span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs text-emerald-600">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" /></svg>
                                        Ready for transfer
                                    </span>
                                @endif
                            </span>
                        </label>
                    @empty
                        <p class="py-6 text-center text-sm text-slate-400">You have no accounts yet.</p>
                    @endforelse
                </div>

                <button type="submit" class="btn-navy mt-6 w-full py-3.5">
                    Continue Transfer
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </button>
            </form>
        </div>

        {{-- Deposit shortcut --}}
        <div class="card flex flex-col p-6">
            <h3 class="text-base font-bold text-navy-900">Need to add funds instead?</h3>
            <p class="mt-1 text-xs text-slate-500">Deposit money into one of your accounts from an external source.</p>
            <div class="flex flex-1 items-center justify-center py-6">
                <span class="flex h-24 w-24 items-center justify-center rounded-full bg-brand-50 text-brand-500">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" /></svg>
                </span>
            </div>
            <a href="{{ route('deposit.index') }}" class="btn-navy w-full py-3.5">
                Deposit Funds
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
            </a>
        </div>
    </div>

    {{-- Recent transfers --}}
    <div class="mt-8">
        <h3 class="mb-4 border-t border-slate-200 pt-6 text-lg font-bold text-navy-900">Recent Transfers</h3>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            @forelse ($recentTransfers as $tx)
                <div class="card p-4 transition hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <span class="amount text-base text-slate-900">${{ number_format(abs($tx['amount']), 2) }}</span>
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-500">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                        </span>
                    </div>
                    <p class="mt-1 text-xs font-medium text-slate-600">{{ str_replace('Transfer to ', 'To: ', explode(' — ', $tx['description'])[0]) }}</p>
                    <p class="mt-1 font-mono text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($tx['transfer_date'])->format('M d, Y H:i') }}</p>
                </div>
            @empty
                <p class="col-span-3 rounded-xl border border-dashed border-slate-300 py-8 text-center text-sm text-slate-400">No transfers yet — send your first one above.</p>
            @endforelse
        </div>
    </div>
@endsection
