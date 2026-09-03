@extends('layouts.admin')

@section('title', 'Services')
@section('heading', $service->exists ? 'Edit service' : 'New service')

@section('content')
    <form method="POST" enctype="multipart/form-data"
          action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}"
          class="grid grid-cols-1 gap-5 lg:grid-cols-3">
        @csrf
        @if ($service->exists) @method('PUT') @endif

        <div class="lg:col-span-2">
            <x-card title="Details">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-form.field name="title" label="Title" required class="sm:col-span-2">
                        <x-form.input name="title" :value="$service->title" placeholder="Interior architecture"/>
                    </x-form.field>

                    <x-form.field name="key" label="Key" hint="Stable identifier the frontend matches on. Blank = from title.">
                        <x-form.input name="key" :value="$service->key" placeholder="interior-architecture"/>
                    </x-form.field>

                    <x-form.field name="sort_order" label="Sort order" hint="Lower numbers appear first.">
                        <x-form.input name="sort_order" type="number" :value="$service->sort_order ?? 0"/>
                    </x-form.field>

                    <x-form.field name="description" label="Description" class="sm:col-span-2">
                        <x-form.textarea name="description" :rows="6" :value="$service->description"/>
                    </x-form.field>
                </div>
            </x-card>
        </div>

        <div class="space-y-5">
            <x-card title="Media">
                <x-form.image name="image" :value="$service->image" label="Illustration" required/>
            </x-card>

            @include('admin.partials.form-actions', ['cancel' => route('admin.services.index'), 'model' => $service])
        </div>
    </form>

    @include('admin.partials.delete-card', [
        'model' => $service,
        'delete' => $service->exists ? route('admin.services.destroy', $service) : null,
    ])
@endsection
