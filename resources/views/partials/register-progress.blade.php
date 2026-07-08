@php
    $steps = [
        1 => ['label' => 'Personal Info', 'icon' => 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z'],
        2 => ['label' => 'ID Verification', 'icon' => 'M10 6h4m-4.75 4.5h5.5m-7.5 6h9.5A2.25 2.25 0 0 0 19 14.25v-8.5A2.25 2.25 0 0 0 16.75 3.5h-9.5A2.25 2.25 0 0 0 5 5.75v8.5a2.25 2.25 0 0 0 2.25 2.25Zm4.75 0v4l2-1.5 2 1.5v-4'],
        3 => ['label' => 'Security', 'icon' => 'M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z'],
        4 => ['label' => 'Complete', 'icon' => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
    ];
@endphp
<div class="flex items-center justify-between border-b border-slate-200 bg-slate-50 px-8 py-4 rounded-t-2xl">
    <div class="flex w-full items-center">
        @foreach ($steps as $n => $s)
            <div class="flex flex-col items-center">
                @if ($n < $current)
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-500 text-white">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                    </span>
                @elseif ($n === $current)
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-600 text-white ring-4 ring-brand-100">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}" /></svg>
                    </span>
                @else
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-slate-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}" /></svg>
                    </span>
                @endif
                <span class="mt-1.5 whitespace-nowrap text-[10px] font-semibold {{ $n <= $current ? 'text-brand-700' : 'text-slate-400' }}">{{ $s['label'] }}</span>
            </div>
            @if (! $loop->last)
                <div class="mx-2 mb-5 h-0.5 flex-1 rounded {{ $n < $current ? 'bg-emerald-500' : 'bg-slate-200' }}"></div>
            @endif
        @endforeach
    </div>
</div>
