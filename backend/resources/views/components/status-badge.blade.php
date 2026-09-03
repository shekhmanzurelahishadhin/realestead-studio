@props(['status'])

@php
    $styles = [
        'available' => 'bg-success/10 text-success',
        'upcoming' => 'bg-warning/15 text-[#b47a17] dark:text-warning',
        'sold' => 'bg-danger/10 text-danger',
    ];
    $label = \App\Http\Controllers\Admin\PropertyController::STATUSES[$status] ?? \Illuminate\Support\Str::headline((string) $status);
@endphp

<span {{ $attributes->class(['hz-badge shrink-0', $styles[$status] ?? 'bg-slate-100 text-slate-500 dark:bg-white/10 dark:text-navy-100']) }}>
    {{ $label }}
</span>
