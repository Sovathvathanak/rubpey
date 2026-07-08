@extends('layouts.auth')

@section('title', 'Re-new PIN')
@section('back-label', 'Back')
@section('back-url', route('password.forgot'))

@section('card')
    <div class="p-8">
        <h1 class="text-center text-lg font-bold text-slate-900">Re-new PIN-Number</h1>
        <p class="mb-6 mt-1 text-center text-xs text-slate-500">Enter your new PIN</p>

        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.reset.post') }}" class="space-y-4">
            @csrf
            <div>
                <label for="pin" class="label">New PIN-Number</label>
                <input id="pin" name="pin" type="password" inputmode="numeric" placeholder="••••••••" class="input" required autofocus>
            </div>
            <div>
                <label for="pin_confirmation" class="label">New PIN-Number Confirm</label>
                <input id="pin_confirmation" name="pin_confirmation" type="password" inputmode="numeric" placeholder="••••••••" class="input" required>
            </div>
            <button type="submit" class="btn-primary w-full rounded-full py-3">Next</button>
        </form>
    </div>
@endsection
