@php
    $steps = [1 => 'Origin', 2 => 'Details', 3 => 'Review'];
@endphp
<div class="mb-8 flex items-center gap-3">
    @foreach ($steps as $n => $label)
        <span class="flex items-center gap-2">
            <span class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-bold {{ $n === $current ? 'bg-brand-600 text-white' : ($n < $current ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-500') }}">
                @if ($n < $current)
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                @else
                    {{ $n }}
                @endif
            </span>
            <span class="text-sm {{ $n === $current ? 'font-bold text-navy-900' : 'text-slate-500' }}">{{ $label }}</span>
        </span>
        @if (! $loop->last)
            <span class="h-px w-16 bg-slate-300"></span>
        @endif
    @endforeach
</div>
