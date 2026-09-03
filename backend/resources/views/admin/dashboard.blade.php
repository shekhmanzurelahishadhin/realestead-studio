@extends('layouts.admin')

@section('title', 'Main Dashboard')

@section('content')
    @php
        $peak = max(1, collect($messagesPerDay)->max('total'));
        $statusTotal = max(1, collect($statusBreakdown)->sum('total'));
        $statusColors = ['bg-brand-600', 'bg-warning', 'bg-slate-300 dark:bg-navy-500'];
    @endphp

    {{-- Stat tiles --}}
    <div class="mb-5 grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-6">
        @foreach ($tiles as $tile)
            <a href="{{ $tile['route'] }}" class="hz-card flex items-center gap-4 p-4 transition hover:-translate-y-0.5">
                <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-[#f4f7fe] text-brand-600 dark:bg-navy-700 dark:text-white">
                    <x-icon :name="$tile['icon']" class="h-6 w-6"/>
                </span>
                <span class="min-w-0">
                    <span class="block truncate text-sm font-medium text-slate-400 dark:text-navy-200">{{ $tile['label'] }}</span>
                    <span class="block text-2xl font-bold text-navy-700 dark:text-white">{{ number_format($tile['value']) }}</span>
                </span>
            </a>
        @endforeach
    </div>

    <div class="mb-5 grid grid-cols-1 gap-5 lg:grid-cols-3">

        {{-- Portfolio value + message volume --}}
        <x-card class="lg:col-span-2">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-400 dark:text-navy-200">Listed portfolio value</p>
                    <p class="mt-1 text-[34px] font-bold leading-none text-navy-700 dark:text-white">
                        {{ $portfolioValue > 0 ? '$'.number_format($portfolioValue / 1_000_000, 1).'M' : '—' }}
                    </p>
                    <p class="mt-2 inline-flex items-center gap-1.5 text-sm font-bold text-success">
                        <span class="h-2 w-2 rounded-full bg-success"></span>
                        {{ number_format($totalMessages) }} enquiries all-time
                    </p>
                </div>
                <span class="rounded-lg bg-[#f4f7fe] px-4 py-2 text-xs font-bold text-slate-500 dark:bg-navy-700 dark:text-navy-100">
                    Last 14 days
                </span>
            </div>

            {{-- Contact-form volume, drawn as plain divs so the panel pulls in no chart library. --}}
            <div class="mt-8 flex h-44 items-end gap-2">
                @foreach ($messagesPerDay as $day)
                    <div class="group flex flex-1 flex-col items-center gap-2" title="{{ $day['label'] }}: {{ $day['total'] }}">
                        <span class="text-[10px] font-bold text-slate-400 opacity-0 transition group-hover:opacity-100 dark:text-navy-200">
                            {{ $day['total'] }}
                        </span>
                        <div class="flex w-full flex-1 items-end">
                            <div class="w-full rounded-t-lg bg-gradient-to-t from-brand-300 to-brand-600 transition group-hover:from-brand-400 group-hover:to-brand-700"
                                 style="height: {{ max(4, round($day['total'] / $peak * 100)) }}%"></div>
                        </div>
                        <span class="text-[10px] font-medium text-slate-400 dark:text-navy-200">{{ $day['short'] }}</span>
                    </div>
                @endforeach
            </div>
        </x-card>

        {{-- Status split --}}
        <x-card title="Properties by status">
            <div class="flex h-4 overflow-hidden rounded-full bg-slate-100 dark:bg-navy-900">
                @foreach ($statusBreakdown as $i => $row)
                    @if ($row['total'] > 0)
                        <div class="{{ $statusColors[$i] ?? 'bg-slate-300' }}"
                             style="width: {{ round($row['total'] / $statusTotal * 100, 2) }}%"></div>
                    @endif
                @endforeach
            </div>

            <ul class="mt-6 space-y-4">
                @foreach ($statusBreakdown as $i => $row)
                    <li class="flex items-center gap-3">
                        <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $statusColors[$i] ?? 'bg-slate-300' }}"></span>
                        <span class="flex-1 text-sm font-medium text-slate-400 dark:text-navy-200">{{ $row['label'] }}</span>
                        <span class="text-sm font-bold text-navy-700 dark:text-white">{{ $row['total'] }}</span>
                    </li>
                @endforeach
            </ul>

            <a href="{{ route('admin.properties.create') }}" class="hz-btn-primary mt-8 w-full">
                <x-icon name="plus" class="h-4 w-4"/> New property
            </a>
        </x-card>
    </div>

    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">

        {{-- Recent messages --}}
        <x-card title="Latest enquiries" :subtitle="$unread > 0 ? $unread.' unread' : 'All caught up'">
            <x-slot:actions>
                <a href="{{ route('admin.messages.index') }}" class="text-sm font-bold text-brand-600 hover:underline dark:text-white">See all</a>
            </x-slot:actions>

            @forelse ($recentMessages as $message)
                <a href="{{ route('admin.messages.show', $message) }}"
                   class="-mx-2 flex items-center gap-3 rounded-xl px-2 py-3 transition hover:bg-[#f4f7fe] dark:hover:bg-white/5">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-50 text-xs font-bold text-brand-600 dark:bg-white/10 dark:text-white">
                        {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($message->name, 0, 2)) }}
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block truncate text-sm font-bold text-navy-700 dark:text-white">{{ $message->name }}</span>
                        <span class="block truncate text-xs font-medium text-slate-400 dark:text-navy-200">{{ $message->subject ?: $message->email }}</span>
                    </span>
                    @unless ($message->is_read)
                        <span class="hz-badge bg-danger/10 text-danger">New</span>
                    @endunless
                    <span class="shrink-0 text-xs font-medium text-slate-400 dark:text-navy-200">{{ $message->created_at->diffForHumans(short: true) }}</span>
                </a>
            @empty
                <x-empty-state message="No enquiries have come in yet."/>
            @endforelse
        </x-card>

        {{-- Recent properties --}}
        <x-card title="Recently added properties">
            <x-slot:actions>
                <a href="{{ route('admin.properties.index') }}" class="text-sm font-bold text-brand-600 hover:underline dark:text-white">See all</a>
            </x-slot:actions>

            @forelse ($recentProperties as $property)
                <a href="{{ route('admin.properties.edit', $property) }}"
                   class="-mx-2 flex items-center gap-3 rounded-xl px-2 py-3 transition hover:bg-[#f4f7fe] dark:hover:bg-white/5">
                    <img src="{{ \App\Support\Media::url($property->image) }}" alt=""
                         class="h-10 w-14 shrink-0 rounded-lg object-cover">
                    <span class="min-w-0 flex-1">
                        <span class="block truncate text-sm font-bold text-navy-700 dark:text-white">{{ $property->title }}</span>
                        <span class="block truncate text-xs font-medium text-slate-400 dark:text-navy-200">{{ $property->location }}</span>
                    </span>
                    <x-status-badge :status="$property->status"/>
                </a>
            @empty
                <x-empty-state message="No properties yet." :action="route('admin.properties.create')" action-label="Add a property"/>
            @endforelse
        </x-card>
    </div>
@endsection
