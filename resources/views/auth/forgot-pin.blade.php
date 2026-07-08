@extends('layouts.auth')

@section('title', 'Forgot PIN')
@section('back-label', 'Back')
@section('back-url', route('login'))

@section('card')
    <div class="p-8">
        <span class="mx-auto mb-4 flex h-12 w-12 items-center justify-center text-brand-600">
            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3h.008v.008H12v-.008ZM12 2.714l8.25 3.667v5.104c0 5.022-3.5 9.71-8.25 10.929-4.75-1.219-8.25-5.907-8.25-10.93V6.382L12 2.715Z" /></svg>
        </span>

        <h1 class="text-center text-lg font-bold text-slate-900">Forgot PIN-Number</h1>
        <p class="mx-auto mb-6 mt-1 max-w-[240px] text-center text-xs text-slate-500">Enter ID Number and Phone Number for Verification</p>

        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.verify') }}" class="space-y-4">
            @csrf
            <div>
                <label for="national_id" class="label">ID Number</label>
                <input id="national_id" name="national_id" type="text" value="{{ old('national_id') }}" placeholder="000000000" class="input" required autofocus>
            </div>
            <div>
                <label for="phone" class="label">Phone Number</label>
                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="+855-000-000-0000" class="input" required>
            </div>
            <button type="submit" class="btn-primary w-full rounded-full py-3">Send</button>
        </form>
    </div>
@endsection
