@extends('layouts.admin')

@section('title', 'Process Steps')

@section('content')
    <x-card title="Process steps" subtitle="The numbered “how we work” sequence on the public site.">
        <x-slot:actions>
            <a href="{{ route('admin.process-steps.create') }}" class="hz-btn-primary">
                <x-icon name="plus" class="h-4 w-4"/> New step
            </a>
        </x-slot:actions>

        @forelse ($steps as $step)
            <div class="flex items-start gap-4 border-b border-slate-100 py-5 last:border-0 dark:border-white/5">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-600 text-sm font-bold text-white">
                    {{ $step->index_label }}
                </span>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-bold text-navy-700 dark:text-white">{{ $step->title }}</p>
                    <p class="mt-1 text-xs font-medium leading-relaxed text-slate-400 dark:text-navy-200">
                        {{ \Illuminate\Support\Str::limit($step->description, 160) }}
                    </p>
                </div>

                <span class="shrink-0 text-xs font-medium text-slate-400">#{{ $step->sort_order }}</span>

                <x-row-actions :edit="route('admin.process-steps.edit', $step)"
                               :delete="route('admin.process-steps.destroy', $step)"/>
            </div>
        @empty
            <x-empty-state message="No process steps yet."
                           :action="route('admin.process-steps.create')" action-label="Add the first step"/>
        @endforelse
    </x-card>
@endsection
