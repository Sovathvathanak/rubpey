@php
    $steps = [1 => 'Origin', 2 => 'Details', 3 => 'Review'];
@endphp
<div class="mb-8 flex items-center">
    @foreach ($steps as $n => $label)
        <span class="flex items-center gap-2.5">
            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-xs font-bold transition
                {{ $n === $current ? 'bg-brand-600 text-white ring-4 ring-brand-100' : ($n < $current ? 'bg-emerald-500 text-white' : 'border-2 border-slate-200 bg-white text-slate-400') }}">
                @if ($n < $current)
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                @else
                    {{ $n }}
                @endif
            </span>
            <span class="text-sm {{ $n === $current ? 'font-bold text-navy-900' : ($n < $current ? 'font-semibold text-emerald-600' : 'text-slate-500') }} {{ $n !== $current ? 'hidden sm:inline' : '' }}">{{ $label }}</span>
        </span>
        @if (! $loop->last)
            <span class="mx-3 h-0.5 w-8 rounded-full sm:w-16 {{ $n < $current ? 'bg-emerald-400' : 'bg-slate-200' }}"></span>
        @endif
    @endforeach
</div>
