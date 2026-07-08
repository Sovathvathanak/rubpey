@extends('layouts.app')

@section('title', 'Open New Account')
@section('page-title', 'Account')

@section('content')
    <h2 class="mb-8 text-3xl font-bold text-navy-900">Open New Account</h2>

    <form method="POST" action="{{ route('accounts.store') }}" class="max-w-3xl">
        @csrf
        <div class="space-y-5">
            <div class="max-w-md">
                <label for="account_name" class="label">Bank Account Name</label>
                <input id="account_name" name="account_name" type="text" value="{{ old('account_name') }}" placeholder="e.g. Main Savings" class="input bg-white" required autofocus>
                @error('account_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="max-w-[220px]">
                <label for="account_type" class="label">Account Type</label>
                <select id="account_type" name="account_type" class="input bg-white" required>
                    <option value="Savings" @selected(old('account_type') === 'Savings')>Savings</option>
                    <option value="Checking" @selected(old('account_type') === 'Checking')>Checking</option>
                </select>
                @error('account_type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="max-w-[220px]">
                <label for="currency" class="label">Currency</label>
                <select id="currency" name="currency" class="input bg-white" required>
                    <option value="USD" @selected(old('currency') === 'USD')>USD ($)</option>
                    <option value="KHR" @selected(old('currency') === 'KHR')>Riel (៛)</option>
                </select>
                @error('currency')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mt-10 flex items-center justify-end gap-4 rounded-lg bg-slate-200/70 px-6 py-4">
            <a href="{{ route('accounts.index') }}" class="text-sm font-bold text-navy-900 hover:text-navy-700">Cancel</a>
            <button type="submit" class="btn-navy bg-[#1e5b8f] hover:bg-[#174a75]">Add Account</button>
        </div>
    </form>
@endsection
