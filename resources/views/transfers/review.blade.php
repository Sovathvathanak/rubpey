@extends('layouts.app')

@section('title', 'Review Transfer')
@section('page-title', 'Review Transfer')

@section('content')
    <div class="mb-6 flex items-center gap-3 rounded-lg bg-navy-800 px-5 py-3.5 text-sm text-slate-200">
        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" /></svg>
        Please review these details carefully. This action cannot be undone once confirmed.
    </div>

    @include('partials.transfer-steps', ['current' => 3])

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Summary --}}
        <div class="card p-8 lg:col-span-2">
            <div class="flex items-center justify-between border-b border-slate-100 pb-5">
                <h2 class="text-lg font-bold text-navy-900">Transfer Summary</h2>
                <span class="pill-green">Awaiting Confirmation</span>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="space-y-5">
                    <div>
                        <span class="stat-label">From Account</span>
                        <span class="mt-2 flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-100 text-brand-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" /></svg>
                            </span>
                            <span>
                                <span class="block text-sm font-bold text-slate-900">{{ $source['account_name'] }}</span>
                                <span class="font-mono text-xs text-slate-500">{{ $source['account_number'] }}</span>
                            </span>
                        </span>
                    </div>
                    <div>
                        <span class="stat-label">To Account</span>
                        <span class="mt-2 flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-100 text-brand-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                            </span>
                            <span>
                                <span class="block text-sm font-bold text-slate-900">{{ $recipientCustomer['first_name'] }} {{ $recipientCustomer['last_name'] }}</span>
                                <span class="font-mono text-xs text-slate-500">RubPey · {{ $recipient['account_number'] }}</span>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="space-y-5">
                    <div>
                        <span class="stat-label">Transfer Amount</span>
                        <p class="amount mt-1 text-3xl text-slate-900">{{ $source['currency'] === 'KHR' ? '៛' : '$' }}{{ number_format($details['amount'], 2) }}</p>
                        <p class="text-xs text-slate-500">Fee: $0.00 (Internal transfer)</p>
                    </div>
                    <div>
                        <span class="stat-label">Currency Rule</span>
                        <p class="mt-1 text-xs text-slate-500">Both accounts must use {{ $source['currency'] }}. Cross-currency transfers are not supported.</p>
                    </div>
                </div>
            </div>

            @if ($details['remark'])
                <div class="mt-6 border-t border-slate-100 pt-5">
                    <span class="stat-label">Message (Optional)</span>
                    <p class="mt-1 text-sm italic text-slate-600">"{{ $details['remark'] }}"</p>
                </div>
            @endif
        </div>

        {{-- PIN confirm --}}
        <div class="card h-fit p-6">
            <h3 class="flex items-center gap-2 text-base font-bold text-brand-700">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" /></svg>
                Security
            </h3>

            <form method="POST" action="{{ route('transfers.confirm') }}" class="mt-4">
                @csrf
                <label for="pin" class="label">Enter PIN Number</label>
                <input id="pin" name="pin" type="password" inputmode="numeric" placeholder="••••••" class="input text-center font-mono tracking-[0.5em]" required autofocus>
                @error('pin')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror

                <button type="submit" class="btn mt-5 w-full bg-emerald-800 py-3 text-white hover:bg-emerald-700">Confirm</button>
            </form>
            <a href="{{ route('transfers.details') }}" class="btn mt-3 w-full border border-red-300 bg-white text-red-600 hover:bg-red-50">Cancel</a>
        </div>
    </div>
@endsection
