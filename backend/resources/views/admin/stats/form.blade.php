@extends('layouts.admin')

@section('title', 'Stats')
@section('heading', $stat->exists ? 'Edit stat' : 'New stat')

@section('content')
    <form method="POST"
          action="{{ $stat->exists ? route('admin.stats.update', $stat) : route('admin.stats.store') }}"
          class="grid grid-cols-1 gap-5 lg:grid-cols-3">
        @csrf
        @if ($stat->exists) @method('PUT') @endif

        <div class="lg:col-span-2">
            <x-card title="Details">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-form.field name="label" label="Label" required class="sm:col-span-2">
                        <x-form.input name="label" :value="$stat->label" placeholder="Projects delivered"/>
                    </x-form.field>

                    <x-form.field name="value" label="Value" required hint="The number the counter animates to.">
                        <x-form.input name="value" type="number" step="any" :value="$stat->value" placeholder="120"/>
                    </x-form.field>

                    <x-form.field name="suffix" label="Suffix" hint="Appended verbatim, e.g. “+”, “%”, “M”.">
                        <x-form.input name="suffix" :value="$stat->suffix" placeholder="+"/>
                    </x-form.field>

                    <x-form.field name="sort_order" label="Sort order" hint="Lower numbers appear first.">
                        <x-form.input name="sort_order" type="number" :value="$stat->sort_order ?? 0"/>
                    </x-form.field>
                </div>
            </x-card>
        </div>

        <div class="space-y-5">
            @include('admin.partials.form-actions', ['cancel' => route('admin.stats.index'), 'model' => $stat])
        </div>
    </form>

    @include('admin.partials.delete-card', [
        'model' => $stat,
        'delete' => $stat->exists ? route('admin.stats.destroy', $stat) : null,
    ])
@endsection
