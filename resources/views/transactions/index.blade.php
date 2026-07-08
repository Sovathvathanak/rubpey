@extends('layouts.app')

@section('title', 'Transaction History')
@section('page-title', 'Transaction History')

@section('content')
    {{-- Filters --}}
    <form method="GET" action="{{ route('transactions.index') }}" class="mb-6 flex flex-wrap items-end gap-4">
        <div>
            <label for="from" class="stat-label mb-1.5 block">From Date</label>
            <input id="from" name="from" type="date" value="{{ $filters['from'] }}" class="input w-44 bg-white">
        </div>
        <div>
            <label for="to" class="stat-label mb-1.5 block">To Date</label>
            <input id="to" name="to" type="date" value="{{ $filters['to'] }}" class="input w-44 bg-white">
        </div>
        <div>
            <label for="status" class="stat-label mb-1.5 block">Status</label>
            <select id="status" name="status" class="input w-40 bg-white">
                @foreach (['all' => 'All Types', 'Completed' => 'Completed', 'Processing' => 'Processing', 'Failed' => 'Failed'] as $value => $label)
                    <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-outline">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" /></svg>
            Apply Filters
        </button>
        @if ($filters['from'] || $filters['to'] || $filters['status'] !== 'all')
            <a href="{{ route('transactions.index') }}" class="text-sm font-medium text-slate-500 hover:text-navy-900">Clear</a>
        @endif
    </form>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[820px]">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="th">Transaction ID</th>
                        <th class="th">Account #</th>
                        <th class="th">Transfer Ref</th>
                        <th class="th">Description</th>
                        <th class="th">Date/Time</th>
                        <th class="th">Status</th>
                        <th class="th text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($transactions as $tx)
                        @php $acct = $accountsById[$tx['account_id']] ?? null; @endphp
                        <tr class="hover:bg-slate-50/50">
                            <td class="td font-mono text-xs font-semibold">#TR-{{ str_pad($tx['transaction_id'], 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="td font-mono text-xs">{{ $acct['account_number'] ?? '—' }}</td>
                            <td class="td font-mono text-xs">{{ $tx['transfer_id'] ? ($transfersById[$tx['transfer_id']] ?? 'N/A') : 'N/A' }}</td>
                            <td class="td max-w-[220px] font-medium text-slate-900">{{ $tx['description'] }}</td>
                            <td class="td text-xs">{{ \Carbon\Carbon::parse($tx['transfer_date'])->format('M d, Y · H:i') }}</td>
                            <td class="td">@include('partials.status-pill', ['status' => $tx['status']])</td>
                            <td class="td amount text-right {{ $tx['status'] === 'Failed' ? 'text-slate-400' : ($tx['amount'] < 0 ? 'text-red-600' : 'text-emerald-600') }}">
                                {{ $tx['amount'] < 0 ? '-' : '+' }}{{ ($acct['currency'] ?? 'USD') === 'KHR' ? '៛' : '$' }}{{ number_format(abs($tx['amount']), 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="td py-12 text-center text-slate-400">No transactions match your filters.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex items-center justify-between border-t border-slate-100 bg-slate-50 px-6 py-3">
            <span class="text-sm text-slate-500">
                Showing <strong>{{ $total === 0 ? 0 : (($page - 1) * $perPage) + 1 }}–{{ min($page * $perPage, $total) }}</strong> of <strong>{{ $total }}</strong> entries
            </span>
            <div class="flex items-center gap-1.5">
                @php $query = array_filter($filters) + []; @endphp
                <a href="{{ $page > 1 ? route('transactions.index', $query + ['page' => $page - 1]) : '#' }}"
                   class="flex h-8 w-8 items-center justify-center rounded border border-slate-200 bg-white text-slate-500 {{ $page > 1 ? 'hover:border-brand-500 hover:text-brand-600' : 'cursor-default opacity-40' }}">‹</a>
                @for ($p = 1; $p <= $lastPage; $p++)
                    <a href="{{ route('transactions.index', $query + ['page' => $p]) }}"
                       class="flex h-8 w-8 items-center justify-center rounded text-sm font-semibold {{ $p === $page ? 'bg-navy-900 text-white' : 'border border-slate-200 bg-white text-slate-600 hover:border-brand-500 hover:text-brand-600' }}">{{ $p }}</a>
                @endfor
                <a href="{{ $page < $lastPage ? route('transactions.index', $query + ['page' => $page + 1]) : '#' }}"
                   class="flex h-8 w-8 items-center justify-center rounded border border-slate-200 bg-white text-slate-500 {{ $page < $lastPage ? 'hover:border-brand-500 hover:text-brand-600' : 'cursor-default opacity-40' }}">›</a>
            </div>
        </div>
    </div>
@endsection
