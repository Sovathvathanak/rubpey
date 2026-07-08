@extends('layouts.app')

@section('title', 'Transfer Failed')
@section('page-title', 'RubPey')

@section('content')
    <div class="card mx-auto max-w-3xl overflow-hidden">
        <div class="border-b border-slate-100 px-8 py-5 text-center">
            <h2 class="text-lg font-bold text-navy-900">RubPey</h2>
        </div>

        <div class="p-10 text-center">
            <span class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-red-100 text-red-600">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
            </span>

            <h2 class="text-2xl font-bold text-slate-900">Transfer Could Not Be Processed</h2>
            <p class="mx-auto mt-2 max-w-sm text-sm text-slate-500">
                We encountered an issue while finalizing your transaction. Please review the details below before attempting the transfer again.
            </p>

            <div class="mt-8 rounded-xl border border-red-100 bg-red-50/60 px-6 py-5 text-left">
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-800">Reason</span>
                        <p class="mt-1 text-sm text-slate-600">{{ $reason }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-4 md:grid-cols-2">
                <a href="{{ route('transfers.details') }}" class="btn-navy py-3">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                    Modify Transfer
                </a>
                <a href="{{ route('dashboard') }}" class="btn bg-slate-200 py-3 text-navy-900 hover:bg-slate-300">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" /></svg>
                    Return to Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection
