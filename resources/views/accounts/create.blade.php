@extends('layouts.app')

@section('title', 'Open New Account')
@section('page-title', 'Account')

@section('content')
    <h2 class="text-2xl font-bold text-navy-900 sm:text-3xl">Open New Account</h2>
    <p class="mb-8 mt-1 text-sm text-slate-500">Set up a new account in just a few seconds.</p>

    <div class="card max-w-2xl overflow-hidden">
        <div class="flex items-center gap-3 border-b border-slate-100 px-8 py-5">
            <span class="icon-tile h-9 w-9">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" /></svg>
            </span>
            <h3 class="text-base font-bold text-navy-900">Account Details</h3>
        </div>

        <form method="POST" action="{{ route('accounts.store') }}">
            @csrf
            <div class="space-y-5 p-8">
                <div>
                    <label for="account_name" class="label">Bank Account Name</label>
                    <input id="account_name" name="account_name" type="text" value="{{ old('account_name') }}" placeholder="e.g. Main Savings" class="input" required autofocus>
                    @error('account_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label for="account_type" class="label">Account Type</label>
                        <select id="account_type" name="account_type" class="input" required>
                            <option value="Savings" @selected(old('account_type') === 'Savings')>Savings</option>
                            <option value="Checking" @selected(old('account_type') === 'Checking')>Checking</option>
                        </select>
                        @error('account_type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="currency" class="label">Currency</label>
                        <select id="currency" name="currency" class="input" required>
                            <option value="USD" @selected(old('currency') === 'USD')>USD ($)</option>
                            <option value="KHR" @selected(old('currency') === 'KHR')>Riel (៛)</option>
                        </select>
                        @error('currency')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 border-t border-slate-100 bg-slate-50 px-8 py-4">
                <a href="{{ route('accounts.index') }}" class="text-sm font-bold text-slate-600 hover:text-navy-900">Cancel</a>
                <button type="submit" class="btn-primary">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Add Account
                </button>
            </div>
        </form>
    </div>
@endsection
