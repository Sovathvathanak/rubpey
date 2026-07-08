@extends('layouts.app')

@section('title', 'Deposit Funds')
@section('page-title', 'RubPey')

@section('content')
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2">
            <h2 class="text-3xl font-bold text-navy-900">Deposit Funds</h2>
            <p class="mb-6 mt-1 text-sm text-slate-500">Select an account and amount to fund your balance.</p>

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('deposit.review') }}" class="card p-6">
                @csrf
                <span class="stat-label">Select Destination Account</span>
                <div class="mt-3 space-y-2.5">
                    @forelse ($accounts as $account)
                        <label class="flex cursor-pointer items-center justify-between rounded-xl border-2 border-slate-200 bg-white px-4 py-3.5 transition hover:border-brand-200 has-checked:border-brand-500 has-checked:bg-brand-50">
                            <span class="flex items-center gap-3">
                                <input type="radio" name="account_id" value="{{ $account['account_id'] }}"
                                       class="h-4 w-4 border-slate-300 text-brand-600 focus:ring-brand-500"
                                       @checked(old('account_id', $data['account_id'] ?? null) == $account['account_id'])>
                                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-100 text-brand-600">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" /></svg>
                                </span>
                                <span>
                                    <span class="block text-sm font-bold text-slate-900">{{ $account['account_name'] }}</span>
                                    <span class="font-mono text-xs text-slate-400">{{ $account['account_number'] }}</span>
                                </span>
                            </span>
                            <span class="amount text-sm text-slate-900">{{ $account['currency'] === 'KHR' ? '៛' : '$' }}{{ number_format($account['balance'], 2) }}</span>
                        </label>
                    @empty
                        <p class="py-6 text-center text-sm text-slate-400">No active accounts — open one first.</p>
                    @endforelse
                </div>

                <div class="mt-6">
                    <label for="amount" class="stat-label">Deposit Amount</label>
                    <div class="relative mt-2">
                        <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center font-mono text-lg text-slate-400">$</span>
                        <input id="amount" name="amount" type="number" step="0.01" min="0.01"
                               value="{{ old('amount', $data['amount'] ?? '') }}"
                               placeholder="0.00" class="input py-4 pl-9 font-mono text-lg" required>
                    </div>
                    <div class="mt-3 flex gap-2.5">
                        @foreach ([100, 500, 1000, 5000] as $quick)
                            <button type="button" data-amount="{{ $quick }}"
                                    class="quick-amount rounded-full border border-slate-300 bg-white px-4 py-1.5 text-xs font-semibold text-slate-700 transition hover:border-brand-500 hover:text-brand-600">
                                ${{ number_format($quick) }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn-navy mt-8 w-full py-3.5">Review Deposit</button>
            </form>
        </div>

        {{-- Status overview --}}
        <div>
            <div class="card mt-[76px] p-6">
                <span class="text-xs font-bold uppercase tracking-wider text-brand-700">Status Overview</span>
                <div class="mt-4 flex items-center justify-between text-sm">
                    <span class="text-slate-600">Daily Deposit Limit</span>
                    <span class="amount text-slate-900">$500,000.00</span>
                </div>
                <div class="mt-3 h-1.5 w-full overflow-hidden rounded-full bg-slate-200">
                    <div class="h-full w-1/4 rounded-full bg-brand-600"></div>
                </div>
                <div class="mt-2 flex items-center justify-between text-xs text-slate-500">
                    <span>Deposits are credited instantly</span>
                    <span class="font-mono">demo</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.quick-amount').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('amount').value = btn.dataset.amount;
            });
        });
    </script>
@endsection
