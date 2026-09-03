@extends('layouts.admin')

@section('title', 'Process Steps')
@section('heading', $step->exists ? 'Edit step' : 'New step')

@section('content')
    <form method="POST"
          action="{{ $step->exists ? route('admin.process-steps.update', $step) : route('admin.process-steps.store') }}"
          class="grid grid-cols-1 gap-5 lg:grid-cols-3">
        @csrf
        @if ($step->exists) @method('PUT') @endif

        <div class="lg:col-span-2">
            <x-card title="Details">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-form.field name="title" label="Title" required class="sm:col-span-2">
                        <x-form.input name="title" :value="$step->title" placeholder="Discovery & brief"/>
                    </x-form.field>

                    <x-form.field name="index_label" label="Badge label" required hint="The number shown in the circle, e.g. “01”.">
                        <x-form.input name="index_label" :value="$step->index_label" placeholder="01"/>
                    </x-form.field>

                    <x-form.field name="key" label="Key" hint="Blank = derived from the title.">
                        <x-form.input name="key" :value="$step->key"/>
                    </x-form.field>

                    <x-form.field name="description" label="Description" class="sm:col-span-2">
                        <x-form.textarea name="description" :rows="6" :value="$step->description"/>
                    </x-form.field>
                </div>
            </x-card>
        </div>

        <div class="space-y-5">
            <x-card title="Ordering">
                <x-form.field name="sort_order" label="Sort order" hint="Lower numbers appear first.">
                    <x-form.input name="sort_order" type="number" :value="$step->sort_order ?? 0"/>
                </x-form.field>
            </x-card>

            @include('admin.partials.form-actions', ['cancel' => route('admin.process-steps.index'), 'model' => $step])
        </div>
    </form>

    @include('admin.partials.delete-card', [
        'model' => $step,
        'delete' => $step->exists ? route('admin.process-steps.destroy', $step) : null,
    ])
@endsection
