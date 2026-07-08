@php
    $pillClass = match ($status) {
        'Completed', 'Active' => 'pill-green',
        'Processing', 'Pending' => 'pill-amber',
        'Failed', 'Closed' => 'pill-red',
        'Frozen' => 'pill-blue',
        default => 'pill-gray',
    };
@endphp
<span class="{{ $pillClass }}">{{ $status }}</span>
