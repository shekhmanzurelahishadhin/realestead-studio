@extends('layouts.admin')

@section('title', 'Properties')

@section('content')
    <x-card>
        <div class="mb-6 flex flex-wrap items-center gap-3">
            <form method="GET" class="flex flex-1 flex-wrap items-center gap-3">
                <label class="relative min-w-56 flex-1">
                    <x-icon name="search" class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"/>
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Search title or location…"
                           class="hz-input rounded-full bg-[#f4f7fe] py-2.5 pl-11 dark:bg-navy-900">
                </label>

                <select name="status" onchange="this.form.submit()" class="hz-input w-auto rounded-full bg-[#f4f7fe] py-2.5 dark:bg-navy-900">
                    <option value="">All statuses</option>
                    @foreach (\App\Http\Controllers\Admin\PropertyController::STATUSES as $key => $label)
                        <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
                    @endforeach
                </select>

                @if (request()->hasAny(['q', 'status']))
                    <a href="{{ route('admin.properties.index') }}" class="hz-btn-ghost py-2.5">Clear</a>
                @endif
            </form>

            <a href="{{ route('admin.properties.create') }}" class="hz-btn-primary">
                <x-icon name="plus" class="h-4 w-4"/> New property
            </a>
        </div>

        @if ($properties->isEmpty())
            <x-empty-state message="No properties match this view."
                           :action="route('admin.properties.create')" action-label="Add a property"/>
        @else
            <div class="-mx-2 overflow-x-auto">
                <table class="w-full min-w-[820px] border-collapse">
                    <thead>
                        <tr>
                            <th class="hz-th">Property</th>
                            <th class="hz-th">Location</th>
                            <th class="hz-th">Price</th>
                            <th class="hz-th">Layout</th>
                            <th class="hz-th">Status</th>
                            <th class="hz-th text-right">Order</th>
                            <th class="hz-th"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($properties as $property)
                            <tr class="transition hover:bg-[#f4f7fe] dark:hover:bg-white/5">
                                <td class="hz-td">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ \App\Support\Media::url($property->image) }}" alt=""
                                             class="h-11 w-16 shrink-0 rounded-lg bg-slate-100 object-cover">
                                        <div class="min-w-0">
                                            <p class="truncate font-bold">{{ $property->title }}</p>
                                            <p class="truncate text-xs font-medium text-slate-400 dark:text-navy-200">/{{ $property->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="hz-td text-slate-500 dark:text-navy-100">{{ $property->location }}</td>
                                <td class="hz-td">
                                    {{ $property->price_label ?: ($property->price ? '$'.number_format($property->price) : '—') }}
                                </td>
                                <td class="hz-td text-slate-500 dark:text-navy-100">
                                    {{ $property->bedrooms ?? 0 }} bd · {{ $property->bathrooms ?? 0 }} ba
                                    @if ($property->area) · {{ number_format($property->area) }} ft² @endif
                                </td>
                                <td class="hz-td"><x-status-badge :status="$property->status"/></td>
                                <td class="hz-td text-right text-slate-400">{{ $property->sort_order }}</td>
                                <td class="hz-td">
                                    <x-row-actions :edit="route('admin.properties.edit', $property)"
                                                   :delete="route('admin.properties.destroy', $property)"/>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">{{ $properties->links() }}</div>
        @endif
    </x-card>
@endsection
