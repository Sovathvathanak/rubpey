@extends('layouts.app')

@section('title', 'Activity History')
@section('page-title', 'RubPey')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-navy-900">Activity History</h2>
            <p class="mt-1 text-sm text-slate-500">Stay updated with your latest security and account activities.</p>
        </div>
        <form method="POST" action="{{ route('activity.read') }}">
            @csrf
            <button type="submit" class="btn-outline-brand">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                Mark all as read
            </button>
        </form>
    </div>

    @php
        $grouped = collect($activities)->groupBy(function ($a) {
            $date = \Carbon\Carbon::parse($a['date']);
            if ($date->isToday()) return 'Today';
            if ($date->isYesterday()) return 'Yesterday';
            return $date->format('M d, Y');
        });
    @endphp

    @forelse ($grouped as $group => $items)
        <p class="mb-3 mt-6 text-xs font-bold uppercase tracking-wider text-brand-600 first:mt-0">{{ $group }}</p>
        <div class="max-w-3xl space-y-3">
            @foreach ($items as $activity)
                <div class="card flex items-start gap-4 p-5 {{ $activity['read'] ? 'opacity-70' : '' }}">
                    @if ($activity['icon'] === 'security')
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
                        </span>
                    @elseif ($activity['icon'] === 'account')
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" /></svg>
                        </span>
                    @else
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-brand-600 text-white">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" /></svg>
                        </span>
                    @endif

                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <h3 class="text-sm font-bold text-slate-900">{{ $activity['title'] }}</h3>
                            <span class="shrink-0 text-xs text-slate-400">{{ \Carbon\Carbon::parse($activity['date'])->format('h:i A') }}</span>
                        </div>
                        <p class="mt-1 text-sm text-slate-500">{{ $activity['body'] }}</p>
                        @unless ($activity['read'])
                            <span class="mt-2 inline-block text-xs font-bold text-brand-500">Unread</span>
                        @endunless
                    </div>
                </div>
            @endforeach
        </div>
    @empty
        <div class="card max-w-3xl p-12 text-center">
            <span class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" /></svg>
            </span>
            <h3 class="text-base font-bold text-slate-900">No activity yet</h3>
            <p class="mt-1 text-sm text-slate-500">Transfers, deposits, and security changes will appear here.</p>
        </div>
    @endforelse
@endsection
