@extends('layouts.admin')

@section('title', 'Stats')

@section('content')
    <x-card title="Headline stats" subtitle="The counters that animate on the home page.">
        <x-slot:actions>
            <a href="{{ route('admin.stats.create') }}" class="hz-btn-primary">
                <x-icon name="plus" class="h-4 w-4"/> New stat
            </a>
        </x-slot:actions>

        @if ($stats->isEmpty())
            <x-empty-state message="No stats yet." :action="route('admin.stats.create')" action-label="Add a stat"/>
        @else
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($stats as $stat)
                    <div class="rounded-[20px] bg-[#f4f7fe] p-5 dark:bg-navy-900">
                        <p class="text-3xl font-bold leading-none text-navy-700 dark:text-white">
                            {{ rtrim(rtrim(number_format($stat->value, 2, '.', ','), '0'), '.') }}<span class="text-brand-600">{{ $stat->suffix }}</span>
                        </p>
                        <p class="mt-2 text-sm font-medium text-slate-400 dark:text-navy-200">{{ $stat->label }}</p>

                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-xs font-medium text-slate-400">#{{ $stat->sort_order }}</span>
                            <x-row-actions :edit="route('admin.stats.edit', $stat)"
                                           :delete="route('admin.stats.destroy', $stat)"/>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-card>
@endsection
