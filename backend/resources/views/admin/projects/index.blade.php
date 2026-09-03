@extends('layouts.admin')

@section('title', 'Projects')

@section('content')
    <x-card>
        <div class="mb-6 flex flex-wrap items-center gap-3">
            <form method="GET" class="flex flex-1 flex-wrap items-center gap-3">
                <label class="relative min-w-56 flex-1">
                    <x-icon name="search" class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"/>
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Search name or location…"
                           class="hz-input rounded-full bg-[#f4f7fe] py-2.5 pl-11 dark:bg-navy-900">
                </label>

                @if ($categories->isNotEmpty())
                    <select name="category" onchange="this.form.submit()" class="hz-input w-auto rounded-full bg-[#f4f7fe] py-2.5 dark:bg-navy-900">
                        <option value="">All categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                @endif

                @if (request()->hasAny(['q', 'category']))
                    <a href="{{ route('admin.projects.index') }}" class="hz-btn-ghost py-2.5">Clear</a>
                @endif
            </form>

            <a href="{{ route('admin.projects.create') }}" class="hz-btn-primary">
                <x-icon name="plus" class="h-4 w-4"/> New project
            </a>
        </div>

        @if ($projects->isEmpty())
            <x-empty-state message="No projects match this view."
                           :action="route('admin.projects.create')" action-label="Add a project"/>
        @else
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
                @foreach ($projects as $project)
                    <article class="group overflow-hidden rounded-[20px] bg-[#f4f7fe] transition hover:-translate-y-0.5 dark:bg-navy-900">
                        <div class="relative h-40 overflow-hidden">
                            <img src="{{ \App\Support\Media::url($project->image) }}" alt=""
                                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            @if ($project->category)
                                <span class="hz-badge absolute left-3 top-3 bg-white/90 text-navy-700">{{ $project->category }}</span>
                            @endif
                        </div>

                        <div class="p-5">
                            <h3 class="truncate text-base font-bold text-navy-700 dark:text-white">{{ $project->name }}</h3>
                            <p class="mt-0.5 truncate text-xs font-medium text-slate-400 dark:text-navy-200">
                                {{ $project->location }}@if ($project->year) · {{ $project->year }}@endif
                            </p>

                            @if (filled($project->stats))
                                <dl class="mt-4 flex flex-wrap gap-x-5 gap-y-2">
                                    @foreach (array_slice($project->stats, 0, 3) as $stat)
                                        <div>
                                            <dt class="text-[10px] font-bold uppercase tracking-wide text-slate-400 dark:text-navy-200">{{ $stat['label'] ?? '' }}</dt>
                                            <dd class="text-sm font-bold text-navy-700 dark:text-white">{{ $stat['value'] ?? '' }}</dd>
                                        </div>
                                    @endforeach
                                </dl>
                            @endif

                            <div class="mt-5 flex items-center justify-between">
                                <span class="text-xs font-medium text-slate-400 dark:text-navy-200">Order {{ $project->sort_order }}</span>
                                <x-row-actions :edit="route('admin.projects.edit', $project)"
                                               :delete="route('admin.projects.destroy', $project)"/>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-6">{{ $projects->links() }}</div>
        @endif
    </x-card>
@endsection
