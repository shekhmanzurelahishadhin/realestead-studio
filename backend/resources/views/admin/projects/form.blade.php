@extends('layouts.admin')

@section('title', 'Projects')
@section('heading', $project->exists ? 'Edit project' : 'New project')

@section('content')
    @php
        // Two parallel input columns rebuild the `stats` label => value map on save.
        // Each row is [label, value]; `stats` is stored as a list of
        // {label, value} objects, which is what the API returns unchanged.
        $oldKeys = old('stat_keys');
        $statRows = $oldKeys === null
            ? collect($project->stats ?? [])->map(fn ($stat) => [$stat['label'] ?? '', $stat['value'] ?? ''])->all()
            : collect($oldKeys)->map(fn ($key, $i) => [$key, old('stat_values.'.$i, '')])->all();
    @endphp

    <form method="POST" enctype="multipart/form-data"
          action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}"
          class="grid grid-cols-1 gap-5 lg:grid-cols-3">
        @csrf
        @if ($project->exists) @method('PUT') @endif

        <div class="space-y-5 lg:col-span-2">
            <x-card title="Details">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-form.field name="name" label="Name" required class="sm:col-span-2">
                        <x-form.input name="name" :value="$project->name" placeholder="Harbour Point"/>
                    </x-form.field>

                    <x-form.field name="slug" label="Slug" hint="Leave blank to derive it from the name.">
                        <x-form.input name="slug" :value="$project->slug"/>
                    </x-form.field>

                    <x-form.field name="location" label="Location" required>
                        <x-form.input name="location" :value="$project->location"/>
                    </x-form.field>

                    <x-form.field name="category" label="Category" hint="Residential, Commercial, Mixed-use…">
                        <x-form.input name="category" :value="$project->category" list="project-categories"/>
                    </x-form.field>

                    <x-form.field name="year" label="Year">
                        <x-form.input name="year" :value="$project->year" placeholder="2024"/>
                    </x-form.field>

                    <x-form.field name="description" label="Description" class="sm:col-span-2">
                        <x-form.textarea name="description" :rows="6" :value="$project->description"/>
                    </x-form.field>
                </div>
            </x-card>

            <x-card title="Key figures" subtitle="Small label / value pairs shown on the project page.">
                {{-- `rows` counts only the blank rows added client-side. --}}
                <div x-data="{ rows: 0 }" class="space-y-3">
                    @foreach ($statRows as [$label, $value])
                        <div class="flex gap-3">
                            <input type="text" name="stat_keys[]" value="{{ $label }}" placeholder="Units" class="hz-input">
                            <input type="text" name="stat_values[]" value="{{ $value }}" placeholder="48" class="hz-input">
                        </div>
                    @endforeach

                    @if (empty($statRows))
                        <div class="flex gap-3">
                            <input type="text" name="stat_keys[]" placeholder="Units" class="hz-input">
                            <input type="text" name="stat_values[]" placeholder="48" class="hz-input">
                        </div>
                    @endif

                    <template x-for="i in rows" :key="i">
                        <div class="flex gap-3">
                            <input type="text" name="stat_keys[]" placeholder="Label" class="hz-input">
                            <input type="text" name="stat_values[]" placeholder="Value" class="hz-input">
                        </div>
                    </template>

                    <button type="button" @click="rows++" class="hz-btn-ghost py-2 text-xs">
                        <x-icon name="plus" class="h-3.5 w-3.5"/> Add row
                    </button>
                    <p class="hz-hint">Rows left without a label are discarded on save.</p>
                </div>
            </x-card>

            <x-card title="Gallery">
                <x-form.gallery name="gallery" :value="$project->gallery ?? []" label="Images"/>
            </x-card>
        </div>

        <div class="space-y-5">
            <x-card title="Media">
                <x-form.image name="image" :value="$project->image" label="Cover image" required/>
            </x-card>

            <x-card title="Ordering">
                <x-form.field name="sort_order" label="Sort order" hint="Lower numbers appear first.">
                    <x-form.input name="sort_order" type="number" :value="$project->sort_order ?? 0"/>
                </x-form.field>
            </x-card>

            @include('admin.partials.form-actions', ['cancel' => route('admin.projects.index'), 'model' => $project])
        </div>
    </form>

    <datalist id="project-categories">
        @foreach (\App\Models\Project::query()->whereNotNull('category')->distinct()->pluck('category') as $category)
            <option value="{{ $category }}"></option>
        @endforeach
    </datalist>

    @include('admin.partials.delete-card', [
        'model' => $project,
        'delete' => $project->exists ? route('admin.projects.destroy', $project) : null,
    ])
@endsection
