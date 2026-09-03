@extends('layouts.admin')

@section('title', 'Services')

@section('content')
    <x-card title="Services" subtitle="Shown on the home page and the services page, in sort order.">
        <x-slot:actions>
            <a href="{{ route('admin.services.create') }}" class="hz-btn-primary">
                <x-icon name="plus" class="h-4 w-4"/> New service
            </a>
        </x-slot:actions>

        @forelse ($services as $service)
            <div class="flex items-center gap-4 border-b border-slate-100 py-4 last:border-0 dark:border-white/5">
                <img src="{{ \App\Support\Media::url($service->image) }}" alt=""
                     class="h-14 w-14 shrink-0 rounded-2xl bg-slate-100 object-cover dark:bg-navy-900">

                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-bold text-navy-700 dark:text-white">{{ $service->title }}</p>
                    <p class="truncate text-xs font-medium text-slate-400 dark:text-navy-200">
                        {{ \Illuminate\Support\Str::limit($service->description, 110) ?: $service->key }}
                    </p>
                </div>

                <span class="hidden shrink-0 rounded-lg bg-[#f4f7fe] px-3 py-1 text-xs font-medium text-slate-500 sm:block dark:bg-navy-900 dark:text-navy-100">
                    {{ $service->key }}
                </span>
                <span class="shrink-0 text-xs font-medium text-slate-400">#{{ $service->sort_order }}</span>

                <x-row-actions :edit="route('admin.services.edit', $service)"
                               :delete="route('admin.services.destroy', $service)"/>
            </div>
        @empty
            <x-empty-state message="No services yet." :action="route('admin.services.create')" action-label="Add a service"/>
        @endforelse
    </x-card>
@endsection
