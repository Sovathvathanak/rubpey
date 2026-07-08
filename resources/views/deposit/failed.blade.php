@extends('layouts.app')

@section('title', 'Deposit Failed')
@section('page-title', 'RubPey')

@section('content')
    <div class="card mx-auto max-w-xl p-10 text-center">
        <span class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-red-100 text-red-600">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
        </span>

        <h2 class="text-2xl font-bold text-slate-900">Deposit Could Not Be Processed</h2>
        <p class="mx-auto mt-2 max-w-sm text-sm text-slate-500">{{ $reason }}</p>

        <div class="mt-8 flex items-center justify-center gap-4">
            <a href="{{ route('deposit.index') }}" class="btn-navy py-3">Try Again</a>
            <a href="{{ route('dashboard') }}" class="btn bg-slate-200 py-3 text-navy-900 hover:bg-slate-300">Return to Dashboard</a>
        </div>
    </div>
@endsection
